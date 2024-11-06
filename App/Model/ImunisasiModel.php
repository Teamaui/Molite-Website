<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class ImunisasiModel
{

    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAll()
    {
        $query = "SELECT * FROM jenis_imunisasi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findJenisImunisasiById($id)
    {
        $query = "SELECT * FROM jenis_imunisasi WHERE id_jenis_imunisasi = :id_jenis_imunisasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_imunisasi", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT jadwal_imunisasi.*, anak.* FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak WHERE jadwal_imunisasi.id_jenis_imunisasi = :id_jenis_imunisasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_imunisasi", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByIdAnak($id)
    {
        $query = "SELECT jadwal_imunisasi.*, anak.*, jenis_imunisasi.* FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi WHERE anak.id_anak = :id_anak";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_anak", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertData(array $data): bool
    {
        $idJensiImunisasi = $this->generateAutoIncrementID();
        $sql = "INSERT INTO jenis_imunisasi (id_jenis_imunisasi, nama_imunisasi, deskripsi_imunisasi) VALUES (:id_jenis_imunisasi, :nama_imunisasi, :deskripsi_imunisasi)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_jenis_imunisasi", $idJensiImunisasi);
        $stmt->bindParam(":nama_imunisasi", $data["nama_imunisasi"]);
        $stmt->bindParam(":deskripsi_imunisasi", $data["deskripsi_imunisasi"]);

        return $stmt->execute();
    }

    public function updateData($data)
    {
        $sql = "UPDATE jenis_imunisasi SET nama_imunisasi = :nama_imunisasi, deskripsi_imunisasi = :deskripsi_imunisasi WHERE id_jenis_imunisasi = :id_jenis_imunisasi";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_jenis_imunisasi", $data["id_jenis_imunisasi"]);
        $stmt->bindParam(":nama_imunisasi", $data["nama_imunisasi"]);
        $stmt->bindParam(":deskripsi_imunisasi", $data["deskripsi_imunisasi"]);

        return $stmt->execute();
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_jenis_imunisasi FROM jenis_imunisasi ORDER BY id_jenis_imunisasi DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_jenis_imunisasi'])) {
                $lastId = $row['id_jenis_imunisasi'];

                // Ambil bagian numerik dari format ID (contoh: JIM0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'JIM' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari JIM0000000001
                $newId = 'JIM0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }
}
