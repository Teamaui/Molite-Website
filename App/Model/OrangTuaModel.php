<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use Exception;
use FlashMessageHelper;
use PDO;
use PDOException;

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

        $query = "SELECT * FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_orang_tua", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAllDataById($id)
    {
        $query = "SELECT orang_tua.*, anak.*, jenis_posyandu.* FROM orang_tua LEFT JOIN anak ON anak.id_orang_tua = orang_tua.id_orang_tua LEFT JOIN jenis_posyandu ON orang_tua.id_posyandu = jenis_posyandu.id_posyandu WHERE orang_tua.id_orang_tua = :id_orang_tua";

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
        try {
            if ($this->cekOrangTuaByEmail($data["email"])) {
                FlashMessageHelper::set("pesan_gagal", "Email sudah digunakan, silakan coba yang lain.");
                return false;
            } else if ($this->cekOrangTuaByNikIbu($data["nik_ibu"])) {
                FlashMessageHelper::set("pesan_gagal", "NIK Ibu sudah digunakan, silakan coba yang lain.");
                return false;
            } else if ($this->cekOrangTuaByNikAyah($data["nik_ayah"])) {
                FlashMessageHelper::set("pesan_gagal", "NIK Ayah sudah digunakan, silakan coba yang lain.");
                return false;
            } else {
                $idAnak = $this->generateAutoIncrementID();
                $sql = "INSERT INTO orang_tua (id_orang_tua, email, nama_ibu, nama_ayah, nik_ibu, nik_ayah, alamat, no_telepon, id_posyandu) VALUES (:id_orang_tua, :email, :nama_ibu, :nama_ayah, :nik_ibu, :nik_ayah, :alamat, :no_telepon, :id_posyandu)";

                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_orang_tua", $idAnak);
                $stmt->bindParam(":email", $data["email"]);
                $stmt->bindParam(":nama_ibu", $data["nama_ibu"]);
                $stmt->bindParam(":nama_ayah", $data["nama_ayah"]);
                $stmt->bindParam(":nik_ibu", $data["nik_ibu"]);
                $stmt->bindParam(":nik_ayah", $data["nik_ayah"]);
                $stmt->bindParam(":alamat", $data["alamat"]);
                $stmt->bindParam(":no_telepon", $data["nomor_telepon"]);
                $stmt->bindParam(":id_posyandu", $data["id_posyandu"]);

                return $stmt->execute();
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateData(array $data): bool
    {
        try {
            $sql = "UPDATE orang_tua SET email = :email, nama_ibu = :nama_ibu, nama_ayah = :nama_ayah, alamat = :alamat, nik_ibu = :nik_ibu, nik_ayah = :nik_ayah, no_telepon = :nomor_telepon, id_posyandu = :id_posyandu WHERE id_orang_tua = :id_orang_tua";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);
            $stmt->bindParam(":email", $data["email"]);
            $stmt->bindParam(":nama_ibu", $data["nama_ibu"]);
            $stmt->bindParam(":nama_ayah", $data["nama_ayah"]);
            $stmt->bindParam(":alamat", $data["alamat"]);
            $stmt->bindParam(":nik_ibu", $data["nik_ibu"]);
            $stmt->bindParam(":nik_ayah", $data["nik_ayah"]);
            $stmt->bindParam(":nomor_telepon", $data["nomor_telepon"]);
            $stmt->bindParam(":id_posyandu", $data["id_posyandu"]);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function registerOrangTua(array $data): bool
    {
        $sql = "UPDATE orang_tua SET email = :email, username = :username, password = :password, status_aktivasi = :status_aktivasi, token_orang_tua = :token_orang_tua WHERE email = :email";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":password", $data["password"]);
        $stmt->bindParam(":token_orang_tua", $data["token"]);
        $stmt->bindValue(":status_aktivasi", "Aktif");

        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            return false;
        } else {
            return true;
        }
    }

    public function loginOrangTua(array $data)
    {
        try {
            $query = "SELECT * FROM orang_tua WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $data["email"]);
            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                return false;
            } else {
                return $stmt->fetch(PDO::FETCH_ASSOC);;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function gantiSandi($data)
    {
        $passwordHash = password_hash($data["sandiBaru"], PASSWORD_DEFAULT);
        $query = "SELECT * FROM orang_tua WHERE id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_orang_tua", $data["id_orang_tua"]);
        $stmt->execute();

        $orangTua = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($orangTua["id_orang_tua"] && password_verify($data["sandiLama"], $orangTua["password"])) {
            $sql = "UPDATE orang_tua SET password = :password WHERE id_orang_tua = :id_orang_tua";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);

            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                return false;
            } else {
                return true;
            }
        } else {
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

    public function cekOrangTua($email)
    {
        $sql = "SELECT * FROM orang_tua WHERE email = :email";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cekStatusOrangTua($email)
    {
        $sql = "SELECT * FROM orang_tua WHERE email = :email AND status_aktivasi = :status_aktivasi";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindValue(":status_aktivasi", "Aktif");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
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

    public function cekOrangTuaByEmail($email)
    {
        $query = "SELECT * FROM orang_tua WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function cekOrangTuaByNikIbu($nikIbu)
    {
        $query = "SELECT * FROM orang_tua WHERE nik_ibu = :nik_ibu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nik_ibu", $nikIbu);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function cekOrangTuaByNikAyah($nikAyah)
    {
        $query = "SELECT * FROM orang_tua WHERE nik_ayah = :nik_ayah";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nik_ayah", $nikAyah);
        $stmt->execute();

        return $stmt->rowCount();
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
