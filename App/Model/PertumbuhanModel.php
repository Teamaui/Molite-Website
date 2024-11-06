<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class PertumbuhanModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAll()
    {

        $query = "SELECT pertumbuhan.*, anak.* FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {

        $query = "SELECT pertumbuhan.*, anak.* FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak WHERE pertumbuhan.id_pertumbuhan = :id_pertumbuhan";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_pertumbuhan", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAllBySearch($search)
    {
        $query = "SELECT * FROM orang_tua WHERE email LIKE :search
       OR nama_ibu LIKE :search
       OR nama_ayah LIKE :search
       OR nik_ibu LIKE :search
       OR nik_ayah LIKE :search
       OR alamat LIKE :search
       OR no_telepon LIKE :search";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertData(array $data): bool
    {
        $idPertumbuhan = $this->generateAutoIncrementID();
        $sql = "INSERT INTO pertumbuhan (id_pertumbuhan, id_anak, tanggal_pencatatan, berat_badan, tinggi_badan, lingkar_kepala) VALUES (:id_pertumbuhan, :id_anak, :tanggal_pencatatan, :berat_badan, :tinggi_badan, :lingkar_kepala)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_pertumbuhan", $idPertumbuhan);
        $stmt->bindParam(":id_anak", $data["id_anak"]);
        $stmt->bindParam(":tanggal_pencatatan", $data["tanggal_catat"]);
        $stmt->bindParam(":berat_badan", $data["berat_badan"]);
        $stmt->bindParam(":tinggi_badan", $data["tinggi_badan"]);
        $stmt->bindParam(":lingkar_kepala", $data["lingkar_kepala"]);

        return $stmt->execute();
    }

    public function updateData(array $data): bool
    {
        $sql = "UPDATE pertumbuhan SET id_anak = :id_anak, tanggal_pencatatan = :tanggal_pencatatan, berat_badan = :berat_badan, tinggi_badan = :tinggi_badan, lingkar_kepala = :lingkar_kepala WHERE id_pertumbuhan = :id_pertumbuhan";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_pertumbuhan", $data["id_pertumbuhan"]);
        $stmt->bindParam(":id_anak", $data["id_anak"]);
        $stmt->bindParam(":tanggal_pencatatan", $data["tanggal_catat"]);
        $stmt->bindParam(":berat_badan", $data["berat_badan"]);
        $stmt->bindParam(":tinggi_badan", $data["tinggi_badan"]);
        $stmt->bindParam(":lingkar_kepala", $data["lingkar_kepala"]);

        return $stmt->execute();
    }

    public function deleteDataById(string $idOrangTua)
    {
        $sql = "DELETE FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_orang_tua", $idOrangTua);

        return $stmt->execute();
    }

    public function getAllPertumbuhanForMouth()
    {
        $query = "SELECT DATE_FORMAT(tanggal_pencatatan, '%M') AS bulan_pencatatan, AVG(berat_badan) AS berat_badan, AVG(tinggi_badan) AS tinggi_badan, AVG(lingkar_kepala) AS lingkar_kepala FROM pertumbuhan GROUP BY bulan_pencatatan ORDER BY tanggal_pencatatan;
        ";

        $this->db->exec("SET lc_time_names = 'id_ID'");
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_pertumbuhan FROM pertumbuhan ORDER BY id_pertumbuhan DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_pertumbuhan'])) {
                $lastId = $row['id_pertumbuhan'];

                // Ambil bagian numerik dari format ID (contoh: PTN0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'PTN' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari PTN0000000001
                $newId = 'PTN0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }
}
