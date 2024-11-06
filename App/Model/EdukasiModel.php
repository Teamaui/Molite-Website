<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class EdukasiModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAll()
    {

        $query = "SELECT jenis_edukasi.id_jenis_edukasi, jenis_edukasi.nama_edukasi, COALESCE(COUNT(edukasi.id_edukasi), 0) AS jumlah_edukasi
        FROM jenis_edukasi LEFT JOIN edukasi ON jenis_edukasi.id_jenis_edukasi = edukasi.id_jenis_edukasi GROUP BY jenis_edukasi.id_jenis_edukasi, jenis_edukasi.nama_edukasi";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllById($id)
    {
        $query = "SELECT edukasi.*, jenis_edukasi.nama_edukasi FROM jenis_edukasi LEFT JOIN edukasi ON jenis_edukasi.id_jenis_edukasi = edukasi.id_jenis_edukasi WHERE jenis_edukasi.id_jenis_edukasi = :id_jenis_edukasi";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_edukasi", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findJenisEdukasiById($id) {
        $query = "SELECT * FROM jenis_edukasi WHERE id_jenis_edukasi = :id_jenis_edukasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_edukasi", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findEdukasiById($id)
    {
        $query = "SELECT * FROM edukasi WHERE id_edukasi = :id_edukasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_edukasi", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDataJenisEdukasi($data): bool
    {
        $idJenisEdukasi = $this->generateAutoIncrementIDJenisEdukasi();

        $query = "INSERT INTO jenis_edukasi (id_jenis_edukasi, nama_edukasi) VALUES (:id_jenis_edukasi, :nama_edukasi)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_edukasi", $idJenisEdukasi);
        $stmt->bindParam(":nama_edukasi", $data["nama_edukasi"]);

        return $stmt->execute();
    }

    public function updateDataJenisEdukasi($data): bool
    {
        $query = "UPDATE jenis_edukasi SET nama_edukasi = :nama_edukasi WHERE id_jenis_edukasi = :id_jenis_edukasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_edukasi", $data["id_jenis_edukasi"]);
        $stmt->bindParam(":nama_edukasi", $data["nama_edukasi"]);

        return $stmt->execute();
    }

    public function insertDataEdukasi($data)
    {
        $idEdukasi = $this->generateAutoIncrementIDEdukasi();

        if (empty($data["foto"]["name"])) {
            // id_admin nik nama_admin email username password status_aktivasi
            $sql = "INSERT edukasi (id_edukasi, id_jenis_edukasi, judul_edukasi, deskripsi_edukasi) VALUES (:id_edukasi,  :id_jenis_edukasi, :judul_edukasi, :deskripsi_edukasi)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_edukasi", $idEdukasi);
            $stmt->bindParam(":id_jenis_edukasi", $data["id_jenis_edukasi"]);
            $stmt->bindParam(":judul_edukasi", $data["judul_edukasi"]);
            $stmt->bindParam(":deskripsi_edukasi", $data["deskripsi_edukasi"]);

            return $stmt->execute();
        } else {
            if ($newFileName = $this->updateImg($data["oldFoto"], $data["foto"])) {
                // id_admin nik nama_admin email username password status_aktivasi
                $sql = "INSERT edukasi (id_edukasi, id_jenis_edukasi, judul_edukasi, deskripsi_edukasi, img) VALUES (:id_edukasi,  :id_jenis_edukasi, :judul_edukasi, :deskripsi_edukasi, :img";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_edukasi", $idEdukasi);
                $stmt->bindParam(":id_jenis_edukasi", $data["id_jenis_edukasi"]);
                $stmt->bindParam(":judul_edukasi", $data["judul_edukasi"]);
                $stmt->bindParam(":deskripsi_edukasi", $data["deskripsi_edukasi"]);
                $stmt->bindParam(":img", $newFileName);

                return $stmt->execute();
            }
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

    private function generateAutoIncrementIDJenisEdukasi()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_jenis_edukasi FROM jenis_edukasi ORDER BY id_jenis_edukasi DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_jenis_edukasi'])) {
                $lastId = $row['id_jenis_edukasi'];

                // Ambil bagian numerik dari format ID (contoh: JDK0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'JDK' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari JDK0000000001
                $newId = 'JDK0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    private function generateAutoIncrementIDEdukasi()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_edukasi FROM edukasi ORDER BY id_edukasi DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_edukasi'])) {
                $lastId = $row['id_edukasi'];

                // Ambil bagian numerik dari format ID (contoh: EDK0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'EDK' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari EDK0000000001
                $newId = 'EDK0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    public function updateImg($oldImg, $foto)
    {
        // Direktori tempat menyimpan foto
        $targetDir = $_SERVER["DOCUMENT_ROOT"] . "/Molita/Public/img/edukasi/";

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
