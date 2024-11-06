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
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.nama_ibu FROM anak INNER JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllBySearch($search)
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.nama_ibu 
          FROM anak 
          INNER JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua
          WHERE anak.nama_anak LIKE :search 
          OR anak.tanggal_lahir LIKE :search
          OR anak.tempat_lahir LIKE :search
          OR anak.jenis_kelamin LIKE :search
          OR orang_tua.nama_ibu LIKE :search";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT anak.id_anak, anak.nama_anak, anak.tanggal_lahir, anak.tempat_lahir, anak.jenis_kelamin, anak.id_orang_tua, orang_tua.* FROM anak INNER JOIN orang_tua ON anak.id_orang_tua = orang_tua.id_orang_tua WHERE anak.id_anak = :id_anak";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_anak", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
