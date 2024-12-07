<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class AnakModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAll()
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.nama_ibu, orang_tua.nama_ayah FROM anak LEFT JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllBySearch($search, $limit, $offset)
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.nama_ibu, orang_tua.nama_ayah 
          FROM anak 
          LEFT JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua
          WHERE anak.nama_anak LIKE :search 
          OR anak.tanggal_lahir LIKE :search
          OR anak.tempat_lahir LIKE :search
          OR anak.jenis_kelamin LIKE :search
          OR orang_tua.nama_ibu LIKE :search OR orang_tua.nama_ayah LIKE :search LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.* FROM anak LEFT JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua WHERE anak.id_anak = :id_anak";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_anak", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByIdOrangTua($id){
        $query = "SELECT anak.* FROM anak JOIN orang_tua ON orang_tua.id_orang_tua = anak.id_orang_tua WHERE orang_tua.id_orang_tua = :id_orang_tua";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();

        if($stmt->rowCount() < 1) {
            return [$stmt->fetchAll(PDO::FETCH_ASSOC)];
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    public function findAllDataByIdOrangTua($id){
        $query = "SELECT 
                    anak.id_anak,
                    anak.nama_anak AS nama_anak,
                    anak.tanggal_lahir,
                    COALESCE(jenis_imunisasi.nama_imunisasi, NULL) AS nama_imunisasi,
                    COALESCE(pertumbuhan.berat_badan, NULL) AS berat_badan,
                    COALESCE(pertumbuhan.tinggi_badan, NULL) AS tinggi_badan,
                    COALESCE(pertumbuhan.lingkar_kepala, NULL) AS lingkar_kepala,
                    COALESCE(pertumbuhan.tanggal_pencatatan, NULL) AS tanggal_pencatatan
                FROM 
                    orang_tua
                JOIN 
                    anak ON anak.id_orang_tua = orang_tua.id_orang_tua
                LEFT JOIN 
                    daftar_imunisasi ON daftar_imunisasi.id_anak = anak.id_anak
                LEFT JOIN 
                    jadwal_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi
                LEFT JOIN 
                    jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi
                LEFT JOIN 
                    pertumbuhan ON pertumbuhan.id_anak = anak.id_anak
                WHERE 
                    orang_tua.id_orang_tua = :id_orang_tua
                AND 
                    (
                        pertumbuhan.tanggal_pencatatan IS NULL OR 
                        pertumbuhan.tanggal_pencatatan = (
                            SELECT MAX(p2.tanggal_pencatatan) 
                            FROM pertumbuhan p2 
                            WHERE p2.id_anak = anak.id_anak
                        )
                    )
                GROUP BY 
                    anak.id_anak;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();

        if($stmt->rowCount() < 1) {
            return [$stmt->fetchAll(PDO::FETCH_ASSOC)];
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    public function insertData(array $data): bool
    {
        $idAnak = $this->generateAutoIncrementID();
        $sql = "INSERT INTO anak (id_anak, nama_anak, tanggal_lahir, tempat_lahir, jenis_kelamin, id_orang_tua) VALUES (:id_anak, :nama_anak, :tanggal_lahir, :tempat_lahir, :jenis_kelamin, :id_orang_tua)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_anak", $idAnak);
        $stmt->bindParam(":nama_anak", $data["nama_anak"]);
        $stmt->bindParam(":tanggal_lahir", $data["tanggal_lahir"]);
        $stmt->bindParam(":tempat_lahir", $data["tempat_lahir"]);
        $stmt->bindParam(":jenis_kelamin", $data["jenis_kelamin"]);
        $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);

        return $stmt->execute();
    }

    public function updateData(array $data): bool
    {
        $sql = "UPDATE anak SET nama_anak = :nama_anak, tanggal_lahir = :tanggal_lahir, tempat_lahir = :tempat_lahir, jenis_kelamin = :jenis_kelamin, id_orang_tua = :id_orang_tua WHERE id_anak = :id_anak";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_anak", $data["id_anak"]);
        $stmt->bindParam(":nama_anak", $data["nama_anak"]);
        $stmt->bindParam(":tanggal_lahir", $data["tanggal_lahir"]);
        $stmt->bindParam(":tempat_lahir", $data["tempat_lahir"]);
        $stmt->bindParam(":jenis_kelamin", $data["jenis_kelamin"]);
        $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);

        return $stmt->execute();
    }

    public function deleteDataById(string $idAnak)
    {
        $sql = "DELETE FROM anak WHERE id_anak = :id_anak";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_anak", $idAnak);

        return $stmt->execute();
    }

    // PAGINATION
    public function getPaginationData($limit, $offset)
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.nama_ibu, orang_tua.nama_ayah FROM anak LEFT JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRows($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM anak
                LEFT JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua
                WHERE anak.nama_anak LIKE :search 
                OR anak.tanggal_lahir LIKE :search
                OR anak.tempat_lahir LIKE :search
                OR anak.jenis_kelamin LIKE :search
                OR orang_tua.nama_ibu  LIKE :search OR orang_tua.nama_ayah LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM anak";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_anak FROM anak ORDER BY id_anak DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Jika terdapat hasil dari query
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['id_anak'];

            // Ambil bagian numerik dari format ID (contoh: OT0001 -> 1)
            $num = (int)substr($lastId, 2);

            // Tambah 1 untuk ID selanjutnya
            $newNum = $num + 1;

            // Format ulang ID dengan leading zeros
            $newId = 'AK' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada ID sebelumnya, mulai dari OT0001
            $newId = 'AK000000001';
        }

        return $newId;
    }
}
