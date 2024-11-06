<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class OrangTuaModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAll()
    {

        $query = "SELECT id_orang_tua, email, nama_ibu, nama_ayah, nik_ibu, nik_ayah, alamat, no_telepon FROM orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {

        $query = "SELECT id_orang_tua, email, nama_ibu, nama_ayah, nik_ibu, nik_ayah, alamat, no_telepon FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_orang_tua", $id);
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
        $idAnak = $this->generateAutoIncrementID();
        $sql = "INSERT INTO orang_tua (id_orang_tua, email, nama_ibu, nama_ayah, nik_ibu, nik_ayah, alamat, no_telepon) VALUES (:id_orang_tua, :email, :nama_ibu, :nama_ayah, :nik_ibu, :nik_ayah, :alamat, :no_telepon)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_orang_tua", $idAnak);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":nama_ibu", $data["nama_ibu"]);
        $stmt->bindParam(":nama_ayah", $data["nama_ayah"]);
        $stmt->bindParam(":nik_ibu", $data["nik_ibu"]);
        $stmt->bindParam(":nik_ayah", $data["nik_ayah"]);
        $stmt->bindParam(":alamat", $data["alamat"]);
        $stmt->bindParam(":no_telepon", $data["nomor_telepon"]);

        return $stmt->execute();
    }

    public function updateData(array $data): bool
    {
        $sql = "UPDATE orang_tua SET email = :email, nama_ibu = :nama_ibu, nama_ayah = :nama_ayah, alamat = :alamat, nik_ibu = :nik_ibu, nik_ayah = :nik_ayah, no_telepon = :nomor_telepon WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":nama_ibu", $data["nama_ibu"]);
        $stmt->bindParam(":nama_ayah", $data["nama_ayah"]);
        $stmt->bindParam(":alamat", $data["alamat"]);
        $stmt->bindParam(":nik_ibu", $data["nik_ibu"]);
        $stmt->bindParam(":nik_ayah", $data["nik_ayah"]);
        $stmt->bindParam(":nomor_telepon", $data["nomor_telepon"]);

        return $stmt->execute();
    }

    public function deleteDataById(string $idOrangTua)
    {
        $sql = "DELETE FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_orang_tua", $idOrangTua);

        return $stmt->execute();
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_jadwal_imunisasi FROM jadwal_imunisasi ORDER BY id_jadwal_imunisasi DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_jadwal_imunisasi'])) {
                $lastId = $row['id_jadwal_imunisasi'];

                // Ambil bagian numerik dari format ID (contoh: OT0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'OT' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari OT0000000001
                $newId = 'OT0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }
}
