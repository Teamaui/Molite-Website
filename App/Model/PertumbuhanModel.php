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

    public function findAllBySearch($search, $limit, $offset)
    {
        $query = "SELECT pertumbuhan.*, anak.* FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak 
        WHERE anak.nama_anak LIKE :search 
        OR pertumbuhan.berat_badan LIKE :search 
        OR pertumbuhan.tinggi_badan LIKE :search 
        OR pertumbuhan.lingkar_kepala LIKE :search 
        OR pertumbuhan.tanggal_pencatatan LIKE :search 
        LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
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

    // PAGINATION
    public function getPaginationData($limit, $offset)
    {
        $query = "SELECT pertumbuhan.*, anak.* FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginationByDate($data)
    {
        $query = "SELECT pertumbuhan.*, anak.* FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak WHERE pertumbuhan.tanggal_pencatatan BETWEEN :start_date AND :end_date LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":start_date", $data["start_date"]);
        $stmt->bindParam(":end_date", $data["end_date"]);
        $stmt->bindParam(":limit", $data["limit"], PDO::PARAM_INT);
        $stmt->bindParam(":offset", $data["offset"], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRows($search = null)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak WHERE anak.nama_anak LIKE :search 
                OR pertumbuhan.berat_badan LIKE :search 
                OR pertumbuhan.tinggi_badan LIKE :search 
                OR pertumbuhan.lingkar_kepala LIKE :search 
                OR pertumbuhan.tanggal_pencatatan LIKE :search ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function getTotalRowsByDate($start_date, $end_date)
    {
        $query = "SELECT COUNT(*) FROM pertumbuhan JOIN anak ON anak.id_anak = pertumbuhan.id_anak WHERE tanggal_pencatatan BETWEEN :start_date AND :end_date";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);
        $stmt->execute();

        return $stmt->fetchColumn();
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
