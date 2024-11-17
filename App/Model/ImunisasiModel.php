<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use FlashMessageHelper;
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

    public function findAllBySearch($search, $limit, $offset)
    {
        $query = "SELECT * FROM jenis_imunisasi WHERE nama_imunisasi LIKE :search
            OR deskripsi_imunisasi LIKE :search
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
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

    public function findSearchViewById($id, $search, $limit, $offset)
    {
        $query = "SELECT jadwal_imunisasi.*, anak.* FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak WHERE anak.nama_anak LIKE :search
            OR jadwal_imunisasi.tanggal_imunisasi LIKE :search OR jadwal_imunisasi.status_imunisasi LIKE :search AND jadwal_imunisasi.id_jenis_imunisasi = :id_jenis_imunisasi LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_imunisasi", $id);
        $stmt->bindParam("search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        if ($this->cekImunisasiByNama($data["nama_imunisasi"])) {
            FlashMessageHelper::set("pesan_gagal", "Nama Imunisasi sudah digunakan, silakan coba yang lain.");
            return false;
        } else {
            $idJensiImunisasi = $this->generateAutoIncrementID();
            $sql = "INSERT INTO jenis_imunisasi (id_jenis_imunisasi, nama_imunisasi, deskripsi_imunisasi) VALUES (:id_jenis_imunisasi, :nama_imunisasi, :deskripsi_imunisasi)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id_jenis_imunisasi", $idJensiImunisasi);
            $stmt->bindParam(":nama_imunisasi", $data["nama_imunisasi"]);
            $stmt->bindParam(":deskripsi_imunisasi", $data["deskripsi_imunisasi"]);

            return $stmt->execute();
        }
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

    // PAGINATION
    public function getPaginationData($limit, $offset)
    {
        $query = "SELECT * FROM jenis_imunisasi LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRows($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM jenis_imunisasi WHERE nama_imunisasi LIKE :search
            OR deskripsi_imunisasi LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM jenis_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function cekImunisasiByNama($nama)
    {
        $query = "SELECT * FROM jenis_imunisasi WHERE LOWER(nama_imunisasi) = LOWER(:nama_imunisasi)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nama_imunisasi", $nama);
        $stmt->execute();

        return $stmt->rowCount();
    }

    // PAGINATION BY ID
    public function getPaginationDataById($id, $limit, $offset)
    {
        $query = "SELECT jadwal_imunisasi.*, anak.* FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak WHERE jadwal_imunisasi.id_jenis_imunisasi = :id_jenis_imunisasi LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jenis_imunisasi", $id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRowsById($id, $search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak WHERE anak.nama_anak LIKE :search
            OR jadwal_imunisasi.tanggal_imunisasi LIKE :search OR jadwal_imunisasi.status_imunisasi LIKE :search AND jadwal_imunisasi.id_jenis_imunisasi = :id_jenis_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jenis_imunisasi", $id);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM jadwal_imunisasi JOIN daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak WHERE jadwal_imunisasi.id_jenis_imunisasi = :id_jenis_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jenis_imunisasi", $id);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function cekImunisasiByNamaById($nama)
    {
        $query = "SELECT * FROM jenis_imunisasi WHERE LOWER(nama_imunisasi) = LOWER(:nama_imunisasi)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nama_imunisasi", $nama);
        $stmt->execute();

        return $stmt->rowCount();
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
