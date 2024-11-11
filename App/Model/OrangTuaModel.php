<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use Exception;
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

        $query = "SELECT id_orang_tua, email, nama_ibu, nama_ayah, nik_ibu, nik_ayah, alamat, no_telepon, status_aktivasi FROM orang_tua";

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

    public function findAllDataById($id)
    {
        $query = "SELECT orang_tua.*, anak.* FROM orang_tua LEFT JOIN anak ON anak.id_orang_tua = orang_tua.id_orang_tua WHERE orang_tua.id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllBySearch($search, $limit, $offset)
    {
        $query = "SELECT * FROM orang_tua WHERE email LIKE :search
       OR nama_ibu LIKE :search
       OR nama_ayah LIKE :search
       OR nik_ibu LIKE :search
       OR nik_ayah LIKE :search
       OR alamat LIKE :search
       OR no_telepon LIKE :search LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
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

    public function registerOrangTua(array $data): bool
    {
        $sql = "UPDATE orang_tua SET username = :username, password = :password, status_aktivasi = :status_aktivasi, token_orang_tua = :token_orang_tua WHERE nik_ibu = :nik_ibu OR nik_ayah = :nik_ayah";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nik_ibu", $data["nik"]);
        $stmt->bindParam(":nik_ayah", $data["nik"]);
        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":password", $data["password"]);
        $stmt->bindParam(":token_orang_tua", $data["token"]);
        $stmt->bindValue(":status_aktivasi", "Aktif");

        return $stmt->execute();
    }

    public function loginOrangTua(array $data): array
    {
        try {
            $query = "SELECT username, email, password, status_aktivasi FROM orang_tua WHERE (nik_ibu = :nik_ibu OR nik_ayah = :nik_ayah)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":nik_ibu", $data["nik"]);
            $stmt->bindParam(":nik_ayah", $data["nik"]);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteDataById(string $idOrangTua)
    {
        $sql = "DELETE FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_orang_tua", $idOrangTua);

        return $stmt->execute();
    }

    // PAGINATION
    public function getPaginationData($limit, $offset)
    {
        $query = "SELECT * FROM orang_tua LIMIT :limit OFFSET :offset";

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

    public function getTotalRows($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM orang_tua WHERE email LIKE :search
            OR nama_ibu LIKE :search
            OR nama_ayah LIKE :search
            OR nik_ibu LIKE :search
            OR nik_ayah LIKE :search
            OR alamat LIKE :search
            OR no_telepon LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM orang_tua";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    private function generateAutoIncrementID()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_orang_tua FROM orang_tua ORDER BY id_orang_tua DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_orang_tua'])) {
                $lastId = $row['id_orang_tua'];

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
