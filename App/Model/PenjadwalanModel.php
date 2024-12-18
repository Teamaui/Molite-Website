<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use Exception;
use FlashMessageHelper;
use PDO;
use PDOException;

class PenjadwalanModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAllPenjadwalanById($id)
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi WHERE jadwal_imunisasi.id_jadwal_imunisasi = :id_jadwal_imunisasi";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_jadwal_imunisasi", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAllPenjadwalan()
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllPosyandu()
    {
        $query = "SELECT * FROM jenis_posyandu";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findPosyanduBydId($id)
    {
        $query = "SELECT * FROM jenis_posyandu WHERE id_posyandu = :id_posyandu";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_posyandu", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findJadwalPosyanduBydId($id)
    {
        $query = "SELECT * FROM jadwal_posyandu WHERE id_jadwal_posyandu = :id_jadwal_posyandu";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jadwal_posyandu", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDataImunisasi($data)
    {
        try {
            $this->db->beginTransaction();

            $idImunisasi = $this->generateAutoIncrementID();
            $idDaftarImunisasi = $this->generateAutoIncrementIDDaftarImunisasi();

            $query = "INSERT INTO jadwal_imunisasi (id_jadwal_imunisasi, id_jenis_imunisasi, tanggal_imunisasi, nama_bidan, usia_pemberian, tempat_imunisasi, status_imunisasi) VALUES (:id_jadwal_imunisasi, :id_jenis_imunisasi, :tanggal_imunisasi, :nama_bidan, :usia_pemberian, :tempat_imunisasi, :status_imunisasi)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_imunisasi", $idImunisasi);
            $stmt->bindParam(":id_jenis_imunisasi", $data["id_jenis_imunisasi"]);
            $stmt->bindParam(":tanggal_imunisasi", $data["tanggal_imunisasi"]);
            $stmt->bindParam(":nama_bidan", $data["nama_bidan"]);
            $stmt->bindParam(":usia_pemberian", $data["usia_pemberian"]);
            $stmt->bindParam(":tempat_imunisasi", $data["tempat_imunisasi"]);
            $stmt->bindParam(":status_imunisasi", $data["status_imunisasi"]);
            $stmt->execute();

            $query2 = "INSERT INTO daftar_imunisasi (id_daftar_imunisasi, id_anak, id_jadwal_imunisasi) VALUES (:id_daftar_imunisasi, :id_anak, :id_jadwal_imunisasi)";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(":id_daftar_imunisasi", $idDaftarImunisasi);
            $stmt2->bindParam(":id_anak", $data["id_anak"]);
            $stmt2->bindParam(":id_jadwal_imunisasi", $idImunisasi);
            $stmt2->execute();

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateJadwalImunisasi($data): bool
    {
        try {

            $this->db->beginTransaction();

            $query = "UPDATE daftar_imunisasi SET id_anak = :id_anak WHERE id_jadwal_imunisasi = :id_jadwal_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_imunisasi", $data["id_jadwal_imunisasi"]);
            $stmt->bindParam(":id_anak", $data["id_anak"]);
            $stmt->execute();

            $query = "UPDATE jadwal_imunisasi SET id_jenis_imunisasi = :id_jenis_imunisasi, tanggal_imunisasi = :tanggal_imunisasi, nama_bidan = :nama_bidan, usia_pemberian = :usia_pemberian, tempat_imunisasi = :tempat_imunisasi, status_imunisasi = :status_imunisasi WHERE id_jadwal_imunisasi = :id_jadwal_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_imunisasi", $data["id_jadwal_imunisasi"]);
            $stmt->bindParam(":id_jenis_imunisasi", $data["id_jenis_imunisasi"]);
            $stmt->bindParam(":tanggal_imunisasi", $data["tanggal_imunisasi"]);
            $stmt->bindParam(":nama_bidan", $data["nama_bidan"]);
            $stmt->bindParam(":usia_pemberian", $data["usia_pemberian"]);
            $stmt->bindParam(":tempat_imunisasi", $data["tempat_imunisasi"]);
            $stmt->bindParam(":status_imunisasi", $data["status_imunisasi"]);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            return false;
        }
    }

    public function insertDataPosyandu($data): bool
    {
        try {
            if ($this->cekPosyanduByPos($data["nama_pos"])) {
                FlashMessageHelper::set("pesan_gagal", "Nama Posyandu sudah digunakan, silakan coba yang lain.");
                return false;
            } else {
                $idPosyandu = $this->generateAutoIncrementIDPosyandu();
                $query = "INSERT INTO jenis_posyandu (id_posyandu, pos) VALUES (:id_posyandu, :pos)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":id_posyandu", $idPosyandu);
                $stmt->bindParam(":pos", $data["nama_pos"]);
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertDataJadwalPosyandu($data): bool
    {
        try {
            $idJadwalPosyandu = $this->generateAutoIncrementIDJadwalPosyandu();
            $query = "INSERT INTO jadwal_posyandu (id_jadwal_posyandu, id_posyandu, tanggal, jam_mulai, jam_selesai) VALUES (:id_jadwal_posyandu, :id_posyandu, :tanggal, :jam_mulai, :jam_selesai)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_posyandu", $idJadwalPosyandu);
            $stmt->bindParam(":id_posyandu", $data["id_posyandu"]);
            $stmt->bindParam(":tanggal", $data["tanggal"]);
            $stmt->bindParam(":jam_mulai", $data["jam_mulai"]);
            $stmt->bindParam(":jam_selesai", $data["jam_selesai"]);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateDataJadwalPosyandu($data): bool
    {
        try {
            $query = "UPDATE jadwal_posyandu SET tanggal = :tanggal, jam_mulai = :jam_mulai, jam_selesai = :jam_selesai WHERE id_jadwal_posyandu = :id_jadwal_posyandu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_posyandu", $data["id_jadwal_posyandu"]);
            $stmt->bindParam(":tanggal", $data["tanggal"]);
            $stmt->bindParam(":jam_mulai", $data["jam_mulai"]);
            $stmt->bindParam(":jam_selesai", $data["jam_selesai"]);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateDataPosyandu($data): bool
    {
        try {
            $query = "UPDATE jenis_posyandu SET pos = :pos WHERE id_posyandu = :id_posyandu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_posyandu", $data["id_posyandu"]);
            $stmt->bindParam(":pos", $data["pos"]);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deletePosyandu($id)
    {
        $query = "DELETE FROM jenis_posyandu WHERE id_posyandu = :id_posyandu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_posyandu", $id);

        return $stmt->execute();
    }

    public function deleteJadwalPosyandu($id)
    {
        $query = "DELETE FROM jadwal_posyandu WHERE id_jadwal_posyandu = :id_jadwal_posyandu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jadwal_posyandu", $id);

        return $stmt->execute();
    }

    public function deleteImunisasi($id)
    {
        try {
            $this->db->beginTransaction();

            $query = "DELETE FROM daftar_imunisasi WHERE id_jadwal_imunisasi = :id_jadwal_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_jadwal_imunisasi", $id);
            $stmt->execute();

            $query2 = "DELETE FROM jadwal_imunisasi WHERE id_jadwal_imunisasi = :id_jadwal_imunisasi";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(":id_jadwal_imunisasi", $id);
            $stmt2->execute();

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    // PAGINATION JADWAL IMUNISASI
    public function getPaginationDataImunisasi($limit, $offset)
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRowsImunisasi($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi WHERE anak.nama_anak LIKE :search
            OR jenis_imunisasi.nama_imunisasi LIKE :search
            OR jadwal_imunisasi.status_imunisasi LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function findAllBySearchImunisasi($search, $limit, $offset)
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi LEFT JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi LEFT JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi WHERE anak.nama_anak LIKE :search
            OR jenis_imunisasi.nama_imunisasi LIKE :search
            OR jadwal_imunisasi.status_imunisasi LIKE :search LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // PAGINATION POSYANDU
    public function getPaginationDataPosyandu($limit, $offset)
    {
        $query = "SELECT * FROM jenis_posyandu LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRowsPosyandu($search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total FROM jenis_posyandu WHERE pos LIKE :search";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM jenis_posyandu";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function findAllBySearchPosyandu($search, $limit, $offset)
    {
        $query = "SELECT * FROM jenis_posyandu WHERE pos LIKE :search";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // PAGINATION JADWAL POSYANDU BY ID
    public function getPaginationDataPosyanduById($idPosyandu, $limit, $offset)
    {
        $query = "SELECT 
            jenis_posyandu.pos,
            jadwal_posyandu.*
        FROM 
            jenis_posyandu
        JOIN 
            jadwal_posyandu 
        ON 
            jadwal_posyandu.id_posyandu = jenis_posyandu.id_posyandu
        WHERE 
            jenis_posyandu.id_posyandu = :id_posyandu LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":id_posyandu", $idPosyandu);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRowsPosyanduById($idPosyandu, $search = false)
    {
        if ($search) {
            $query =  "SELECT COUNT(*) as total jenis_posyandu.pos,
            jadwal_posyandu.*
                FROM 
                    jenis_posyandu
                JOIN 
                    jadwal_posyandu 
                ON 
                    jadwal_posyandu.id_posyandu = jenis_posyandu.id_posyandu
                WHERE 
                    jadwal_posyandu.tanggal LIKE :search OR
                    jadwal_posyandu.jam_mulai LIKE :search OR
                    jadwal_posyandu.jam_selesai LIKE :search AND
                    jenis_posyandu.id_posyandu = :id_posyandu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":search", $search);
            $stmt->bindParam(":id_posyandu", $idPosyandu);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM
                        jenis_posyandu
                    JOIN 
                        jadwal_posyandu 
                    ON 
                        jadwal_posyandu.id_posyandu = jenis_posyandu.id_posyandu
                    WHERE
                        jenis_posyandu.id_posyandu = :id_posyandu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_posyandu", $idPosyandu);
            $stmt->execute();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["total"];
    }

    public function findAllBySearchPosyanduById($idPosyandu, $search, $limit, $offset)
    {
        $query = "SELECT 
            jenis_posyandu.pos,
            jadwal_posyandu.*
        FROM 
            jenis_posyandu
        LEFT JOIN 
            jadwal_posyandu 
        ON 
            jadwal_posyandu.id_posyandu = jenis_posyandu.id_posyandu
        WHERE 
            jadwal_posyandu.tanggal LIKE :search OR
            jadwal_posyandu.jam_mulai LIKE :search OR
            jadwal_posyandu.jam_selesai LIKE :search AND
            jenis_posyandu.id_posyandu = :id_posyandu LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":id_posyandu", $idPosyandu);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cekPosyanduByPos($pos)
    {
        $query = "SELECT * FROM jenis_posyandu WHERE LOWER(pos) = LOWER(:pos)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pos", $pos);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function cekJadwalPosyanduByPos($pos)
    {
        $query = "SELECT * FROM jadwal_posyandu WHERE LOWER(pos) = LOWER(:pos)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":pos", $pos);
        $stmt->execute();

        return $stmt->rowCount();
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

                // Ambil bagian numerik dari format ID (contoh: IJP0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'IJP' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari IJP0000000001
                $newId = 'IJP0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    private function generateAutoIncrementIDPosyandu()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_posyandu FROM jenis_posyandu ORDER BY id_posyandu DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_posyandu'])) {
                $lastId = $row['id_posyandu'];

                // Ambil bagian numerik dari format ID (contoh: JPD0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'JPD' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari JPD0000000001
                $newId = 'JPD0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    private function generateAutoIncrementIDJadwalPosyandu()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_jadwal_posyandu FROM jadwal_posyandu ORDER BY id_jadwal_posyandu DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_jadwal_posyandu'])) {
                $lastId = $row['id_jadwal_posyandu'];

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

    private function generateAutoIncrementIDDaftarImunisasi()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_daftar_imunisasi FROM daftar_imunisasi ORDER BY id_daftar_imunisasi DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_daftar_imunisasi'])) {
                $lastId = $row['id_daftar_imunisasi'];

                // Ambil bagian numerik dari format ID (contoh: DFS0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'DFS' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari DFS0000000001
                $newId = 'DFS0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    public function getPenjadwalanAnak($id)
    {
        $query = "SELECT 
                        jadwal_imunisasi.*, 
                        anak.*, 
                        jenis_imunisasi.*
                    FROM 
                        jadwal_imunisasi
                    LEFT JOIN 
                        daftar_imunisasi ON daftar_imunisasi.id_jadwal_imunisasi = jadwal_imunisasi.id_jadwal_imunisasi
                    LEFT JOIN 
                        anak ON anak.id_anak = daftar_imunisasi.id_anak
                    LEFT JOIN 
                        jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi
                    JOIN 
                        orang_tua ON orang_tua.id_orang_tua = anak.id_orang_tua
                    WHERE 
                        orang_tua.id_orang_tua = :id_orang_tua
                        AND jadwal_imunisasi.tanggal_imunisasi IN (
                            SELECT 
                                MAX(jadwal_imunisasi.tanggal_imunisasi)
                            FROM 
                                daftar_imunisasi
                            JOIN 
                                jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi
                            GROUP BY 
                                daftar_imunisasi.id_anak
                        );";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPosyanduByIdOrangTua($id)
    {
        $query = "SELECT jenis_posyandu.pos, jadwal_posyandu.* FROM jadwal_posyandu JOIN jenis_posyandu ON jenis_posyandu.id_posyandu = jadwal_posyandu.id_posyandu JOIN orang_tua On jenis_posyandu.id_posyandu = orang_tua.id_posyandu WHERE orang_tua.id_orang_tua = :id_orang_tua";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [$stmt->fetchAll(PDO::FETCH_ASSOC)];
        }
    }
}
