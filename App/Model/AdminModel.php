<?php

/**
 * Script untuk mengirim email menggunakan PHPMailer.
 *
 * @copyright  Copyright (c) 2024
 * @license    LGPL 2.1 (https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html)
 * 
 * PHPMailer adalah library open source untuk mengirim email melalui protokol SMTP.
 * Untuk detail lebih lanjut, kunjungi: https://github.com/PHPMailer/PHPMailer
 * 
 * Hak cipta untuk kode asli PHPMailer dimiliki oleh tim pengembang PHPMailer.
 * Script ini memodifikasi PHPMailer untuk kebutuhan khusus pengguna.
 */

namespace Model;

use App\Helper\DatabaseHelper;
use Exception;
use FlashMessageHelper;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
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

    public function insertAdmin(array $data, string $idAdmin): bool
    {
        $dataToken = [
            "email" => $data["email"],
            "subject" => "Akun Anda Menunggu Aktivasi, Klik di Sini!"
        ];

        if ($this->isAktivasi($idAdmin)) {
            FlashMessageHelper::set("pesan_register_gagal", "Akun Anda sudah memiliki token aktivasi. Silakan aktivasi melalui email atau tunggu 15 menit sebelum melakukan registrasi ulang.");
            return false;
        } else if ($this->cekAdminByUsername($data["username"])) {
            FlashMessageHelper::set("pesan_register_gagal", "Username sudah digunakan, silakan coba yang lain.");
            return false;
        }

        try {
            // Mengamankan password
            $sandiAman = password_hash($data["sandi1"], PASSWORD_DEFAULT);

            // Mengirim email aktivasi
            if ($this->sendEmail($dataToken)) {
                // Query untuk update data admin
                $sql = "UPDATE admin SET username = :username, password = :password WHERE nik = :nik";
                $stmt = $this->db->prepare($sql);

                // Binding parameter dengan parameter yang benar
                $stmt->bindParam(":username", $data["username"], PDO::PARAM_STR);
                $stmt->bindParam(":password", $sandiAman, PDO::PARAM_STR);
                $stmt->bindParam(":nik", $data["nik"], PDO::PARAM_STR);

                // Eksekusi query
                $stmt->execute();

                return true;
            } else {
                FlashMessageHelper::set("pesan_register_gagal", "Aktivasi akun gagal. Tautan mungkin sudah kedaluwarsa atau tidak valid. Silakan coba lagi atau hubungi dukungan.");
                return false;
            }
        } catch (Exception $e) {
            // Log error atau tampilkan pesan kesalahan
            error_log("Error: " . $e->getMessage());

            return false;
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

    public function updateDataAdmin($data)
    {
        $sql = "UPDATE admin SET nama_admin = :nama_admin, nik = :nik, email = :email WHERE id_admin = :id_admin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_admin", $data["id_admin"]);
        $stmt->bindParam(":nama_admin", $data["nama_admin"]);
        $stmt->bindParam(":nik", $data["nik"]);
        $stmt->bindParam(":email", $data["email"]);

        return $stmt->execute();
    }

    // PAGINATION
    public function getPaginationData($limit, $offset)
    {
        $query = "SELECT * FROM admin LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalRows($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM admin WHERE nik LIKE :search
            OR nik LIKE :search
            OR nama_admin LIKE :search
            OR email LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM admin";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function findAllBySearch($search, $limit, $offset)
    {
        $query = "SELECT * FROM admin WHERE nik LIKE :search
       OR nama_admin LIKE :search
       OR email LIKE :search LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isAktivasi($idAdmin) {
        $query = "SELECT * FROM aktivasi_token_admin WHERE id_admin = :id_admin";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_admin", $idAdmin);

        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function aktivasiAkun($idAdmin, $token)
    {
        $query = "SELECT * FROM aktivasi_token_admin WHERE token = :token AND id_admin = :id_admin";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_admin", $idAdmin);
        $stmt->bindParam(":token", $token);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            try {
                $this->db->beginTransaction();

                $query = "UPDATE admin SET status_aktivasi = :status_aktivasi WHERE id_admin = :id_admin";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":status_aktivasi", "Aktif");
                $stmt->bindParam(":id_admin", $idAdmin);
                $stmt->execute();

                $query = "DELETE FROM aktivasi_token_admin WHERE token = :token AND id_admin = :id_admin";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":id_admin", $idAdmin);
                $stmt->bindParam(":token", $token);
                $stmt->execute();

                $this->db->commit();

                return true;
            } catch (Exception $e) {
                $this->db->rollBack();
                return false;
            }
        } else {
            return false;
        }
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

    public function sendEmail($data)
    {

        $mail = new PHPMailer(true);

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = :email");
            $stmt->bindParam(":email", $data["email"]);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($admin["id_admin"]) {
                $this->clearOtpAdminById($admin["id_admin"]);

                $idToken = $this->generateAutoIncrementIDAdminAktivasi();
                $kodeToken = bin2hex(random_bytes(32 / 2));

                $sql = "INSERT INTO aktivasi_token_admin (id_token, id_admin, token) VALUES (:id_token, :id_admin, :token)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_token", $idToken);
                $stmt->bindParam(":id_admin", $admin["id_admin"]);
                $stmt->bindParam(":token", $kodeToken);

                $stmt->execute();

                $template = file_get_contents(__DIR__ . "/../View/Respon/aktivasiTemplate.php");

                $placeholders = [
                    "{{USER_NAME}}" => $admin["nama_admin"],
                    "{{USER_ID}}" => $admin["id_admin"],
                    "{{ACTIVATION_TOKEN}}" => $kodeToken
                ];

                $emailBody = strtr($template, $placeholders);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'teamaui29@gmail.com';
                $mail->Password = 'nuil goun mqje uwbj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('teamaui29@gmail.com', 'Molita');
                $mail->addAddress($data["email"]);
                $mail->isHTML(true);
                $mail->Subject = $data["subject"];
                $mail->Body = $emailBody;

                $mail->send();

                $this->db->commit();
                return $admin;
            } else {
                FlashMessageHelper::set("pesan_gagal", "Email yang anda masukkan belum terdaftar!");
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "<div class='error'>Email gagal dikirim. Kesalahan: {$mail->ErrorInfo}</div>";
            FlashMessageHelper::set("pesan_gagal", "Gagal Register!");
            return false;
        }
    }

    private function generateAutoIncrementIDAdminAktivasi()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_token FROM aktivasi_token_admin ORDER BY id_token DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_token'])) {
                $lastId = $row['id_token'];

                // Ambil bagian numerik dari format ID (contoh: AKA0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'AKA' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari AKA0000000001
                $newId = 'AKA0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    public function clearOtpAdminById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM aktivasi_token_admin WHERE id_admin = :id_admin");
        $stmt->bindParam(":id_admin", $id);
        $stmt->execute();
    }
}
