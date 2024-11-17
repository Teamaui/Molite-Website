<?php

namespace Model;

use App\Helper\DatabaseHelper;
use FlashMessageHelper;
use PDO;
use UrlHelper;

class AdminModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAdminByUniqueNik(string $nik)
    {
        $sql = "SELECT * FROM admin WHERE nik = :nik";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nik", $nik);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function findAdminByUniqueNikOrEmail(string $nik_or_email)
    {
        $sql = "SELECT * FROM admin WHERE nik = :nik OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nik", $nik_or_email);
        $stmt->bindParam(":email", $nik_or_email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function findAll()
    {
        $sql = "SELECT * FROM admin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function findAdminByUniqueId(string $idAdmin)
    {
        $sql = "SELECT * FROM admin WHERE id_admin = :id_admin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_admin", $idAdmin);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function insertAdmin(array $data): bool
    {
        if ($this->cekAdminByUsername($data["username"])) {
            FlashMessageHelper::set("pesan_register_gagal", "Username sudah digunakan, silakan coba yang lain.");
            return false;
        } else {
            $sandiAman = password_hash($data["sandi1"], PASSWORD_DEFAULT);

            $sql = "UPDATE admin SET username = :username, status_aktivasi = :status_aktivasi, password = :password WHERE nik = :nik";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":status_aktivasi", "Aktif");
            $stmt->bindParam(":username", $data["username"]);
            $stmt->bindParam(":password", $sandiAman);
            $stmt->bindParam(":nik", $data["nik"]);

            return $stmt->execute();
        }
    }

    public function insertNewAdmin(array $data)
    {
        if ($this->cekAdminByNik($data["nik"])) {
            FlashMessageHelper::set("pesan_gagal", "NIK sudah digunakan, silakan coba yang lain.");
            return false;
        } else if ($this->cekAdminByEmail($data["email"])) {
            FlashMessageHelper::set("pesan_gagal", "Email sudah digunakan, silakan coba yang lain.");
            return false;
        } else {
            $id_admin = $this->generateAutoIncrementID();
            $query = "INSERT INTO admin (id_admin, nik, nama_admin, email) VALUES (:id_admin , :nik , :nama_admin , :email)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_admin", $id_admin);
            $stmt->bindParam(":nik", $data["nik"]);
            $stmt->bindParam(":nama_admin", $data["nama_admin"]);
            $stmt->bindParam(":email", $data["email"]);

            return $stmt->execute();
        }
    }

    public function updateData($data)
    {
        $idAdmin = $_SESSION["id_admin"];


        if (empty($data["foto"]["name"])) {
            // id_admin nik nama_admin email username password status_aktivasi
            $sql = "UPDATE admin SET nik = :nik, nama_admin = :nama_admin, email = :email, username = :username WHERE id_admin = :id_admin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_admin", $idAdmin);
            $stmt->bindParam(":nik", $data["nik"]);
            $stmt->bindParam(":nama_admin", $data["nama_admin"]);
            $stmt->bindParam(":email", $data["email"]);
            $stmt->bindParam(":username", $data["username"]);

            return $stmt->execute();
        } else {
            if ($newFileName = $this->updateImg($data["oldFoto"], $data["foto"])) {
                // id_admin nik nama_admin email username password status_aktivasi
                $sql = "UPDATE admin SET nik = :nik, nama_admin = :nama_admin, email = :email, username = :username, img = :img WHERE id_admin = :id_admin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_admin", $idAdmin);
                $stmt->bindParam(":nik", $data["nik"]);
                $stmt->bindParam(":nama_admin", $data["nama_admin"]);
                $stmt->bindParam(":email", $data["email"]);
                $stmt->bindParam(":username", $data["username"]);
                $stmt->bindParam(":img", $newFileName);

                return $stmt->execute();
            }
        }
    }

    public function updatePassword($data)
    {
        $sandiAman = password_hash($data["new_password"], PASSWORD_DEFAULT);
        $idAdmin = $_SESSION["id_admin"];
        // id_admin nik nama_admin email username password status_aktivasi
        $sql = "UPDATE admin SET nik = :nik, nama_admin = :nama_admin, email = :email, username = :username, password = :password WHERE id_admin = :id_admin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_admin", $idAdmin);
        $stmt->bindParam(":nik", $data["nik"]);
        $stmt->bindParam(":nama_admin", $data["nama_admin"]);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":password", $sandiAman);
        $stmt->bindParam(":nama_admin", $data["nama_admin"]);

        return $stmt->execute();
    }

    public function updateImg($oldImg, $foto)
    {
        // Direktori tempat menyimpan foto
        $targetDir = $_SERVER["DOCUMENT_ROOT"] . "/Molita/Public/img/profile/";

        // Nama file foto lama (misalnya dari database)
        $oldPhoto = $oldImg;

        // Cek apakah ada file yang diunggah
        if (isset($foto) && $foto['error'] === UPLOAD_ERR_OK) {
            // Dapatkan informasi file yang diunggah
            $fileTmpPath = $foto['tmp_name'];
            $fileName = $foto['name'];

            // Dapatkan ekstensi file
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

            // Validasi ekstensi file
            if (in_array($fileExtension, $allowedExtensions)) {
                // Beri nama baru pada file untuk menghindari nama yang sama
                $newFileName = uniqid() . '.' . $fileExtension;
                $targetFilePath = $targetDir . $newFileName;

                // Pindahkan file ke direktori tujuan
                if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                    // Hapus foto lama jika ada

                    if (file_exists($oldPhoto) && $oldPhoto != "default.png") {
                        unlink($oldPhoto);
                    }

                    return $newFileName;
                } else {
                    echo "Terjadi kesalahan saat mengunggah file.";
                    return false;
                }
            } else {
                echo "Format file tidak didukung. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
                return false;
            }
        } else {
            echo "Tidak ada file yang dipilih atau terjadi kesalahan saat mengunggah.";
            return false;
        }
    }

    public function deleteDataById($id)
    {
        $query = "DELETE FROM admin WHERE id_admin = :id_admin";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_admin", $id);

        return $stmt->execute();
    }

    public function cekAdminByNik($nik)
    {
        $query = "SELECT * FROM admin WHERE nik = :nik";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nik", $nik);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function cekAdminByEmail($email)
    {
        $query = "SELECT * FROM admin WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function cekAdminByUsername($username)
    {
        $query = "SELECT * FROM admin WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->rowCount();
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_admin FROM admin ORDER BY id_admin DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_admin'])) {
                $lastId = $row['id_admin'];

                // Ambil bagian numerik dari format ID (contoh: ADM0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'ADM' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari ADM0000000001
                $newId = 'ADM0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }
}
