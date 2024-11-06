<?php

namespace Model;

use App\Helper\DatabaseHelper;
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
        $sandiAman = password_hash($data["sandi1"], PASSWORD_DEFAULT);

        $sql = "UPDATE admin SET username = :username, status_aktivasi = :status_aktivasi, password = :password WHERE nik = :nik";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":status_aktivasi", "Aktif");
        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":password", $sandiAman);
        $stmt->bindParam(":nik", $data["nik"]);

        return $stmt->execute();
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
}
