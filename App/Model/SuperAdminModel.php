<?php

namespace Model;

use App\Helper\DatabaseHelper;
use PDO;

class SuperAdminModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM super_admin WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function updateData($data)
    {
        $idAdmin = $_SESSION["id_super_admin"];

        if (empty($data["foto"]["name"])) {
            // id_admin nik nama_admin email username password status_aktivasi
            $sql = "UPDATE super_admin SET email = :email, nama = :nama, alamat = :alamat WHERE id_super_admin = :id_super_admin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_super_admin", $idAdmin);
            $stmt->bindParam(":email", $data["email"]);
            $stmt->bindParam(":nama", $data["nama"]);
            $stmt->bindParam(":alamat", $data["alamat"]);


            return $stmt->execute();
        } else {
            if ($newFileName = $this->updateImg($data["oldFoto"], $data["foto"])) {
                // id_admin nik nama_admin email username password status_aktivasi
                $sql = "UPDATE super_admin SET email = :email, nama = :nama, alamat = :alamat, img = :img WHERE id_super_admin = :id_super_admin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_super_admin", $idAdmin);
                $stmt->bindParam(":email", $data["email"]);
                $stmt->bindParam(":nama", $data["nama"]);
                $stmt->bindParam(":alamat", $data["alamat"]);
                $stmt->bindParam(":img", $newFileName);

                return $stmt->execute();
            }
        }
    }

    public function updatePassword($data)
    {
        $sandiAman = password_hash($data["new_password"], PASSWORD_DEFAULT);
        $idAdmin = $_SESSION["id_super_admin"];
        // id_admin nik nama_admin email username password status_aktivasi
        $sql = "UPDATE super_admin SET email = :email, nama = :nama, alamat = :alamat, password = :password WHERE id_super_admin = :id_super_admin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_super_admin", $idAdmin);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":nama", $data["nama"]);
        $stmt->bindParam(":alamat", $data["alamat"]);
        $stmt->bindParam(":password", $sandiAman);

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

    public function findSuperAdminByUniqueId(string $idAdmin)
    {
        $sql = "SELECT * FROM super_admin WHERE id_super_admin = :id_super_admin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_super_admin", $idAdmin);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }
}
