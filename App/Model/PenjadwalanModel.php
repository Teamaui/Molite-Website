<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use Exception;
use PDO;

class PenjadwalanModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAllPenjadwalanById($id)
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi WHERE jadwal_imunisasi.id_jadwal_imunisasi = :id_jadwal_imunisasi";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id_jadwal_imunisasi", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAllPenjadwalan()
    {
        $query = "SELECT jenis_imunisasi.*, anak.*, jadwal_imunisasi.* FROM daftar_imunisasi JOIN jadwal_imunisasi ON jadwal_imunisasi.id_jadwal_imunisasi = daftar_imunisasi.id_jadwal_imunisasi JOIN anak ON anak.id_anak = daftar_imunisasi.id_anak JOIN jenis_imunisasi ON jenis_imunisasi.id_jenis_imunisasi = jadwal_imunisasi.id_jenis_imunisasi";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllPosyandu()
    {
        $query = "SELECT * FROM jadwal_posyandu";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllPosyanduBydId($id)
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
            echo $e->getMessage();
            die;
            return false;
        }
    }

    public function updateJadwalImunisasi($data)
    {
        $query = "UPDATE jadwal_imunisasi SET id_jenis_imunisasi = :id_jenis_imunisasi, tanggal_imunisasi = :tanggal_imunisasi, nama_bidan = :nama_bidan, usia_pemberian = :usia_pemberian, tempat_imunisasi = :tempat_imunisasi, status_imunisasi = :status_imunisasi WHERE id_jadwal_imunisasi = :id_jadwal_imunisasi";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jadwal_imunisasi", $data["id_jadwal_imunisasi"]);
        $stmt->bindParam(":id_jenis_imunisasi", $data["id_jenis_imunisasi"]);
        $stmt->bindParam(":tanggal_imunisasi", $data["tanggal_imunisasi"]);
        $stmt->bindParam(":nama_bidan", $data["nama_bidan"]);
        $stmt->bindParam(":usia_pemberian", $data["usia_pemberian"]);
        $stmt->bindParam(":tempat_imunisasi", $data["tempat_imunisasi"]);
        $stmt->bindParam(":status_imunisasi", $data["status_imunisasi"]);
        return $stmt->execute();
    }

    public function insertDataPosyandu($data)
    {
        $idPosyandu = $this->generateAutoIncrementIDPosyandu();

        $query = "INSERT INTO jadwal_posyandu (id_jadwal_posyandu, pos, tanggal, jam) VALUES (:id_jadwal_posyandu, :pos, :tanggal, :jam)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jadwal_posyandu", $idPosyandu);
        $stmt->bindParam(":pos", $data["nama_pos"]);
        $stmt->bindParam(":tanggal", $data["tanggal"]);
        $stmt->bindParam(":jam", $data["jam"]);

        return $stmt->execute();
    }

    public function updateDataPosyandu($data)
    {
        $query = "UPDATE jadwal_posyandu SET pos = :pos, tanggal = :tanggal, jam = :jam WHERE id_jadwal_posyandu = :id_jadwal_posyandu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_jadwal_posyandu", $data["id_jadwal_posyandu"]);
        $stmt->bindParam(":tanggal", $data["tanggal"]);
        $stmt->bindParam(":jam", $data["jam"]);
        $stmt->bindParam(":pos", $data["pos"]);

        return $stmt->execute();
    }

    public function deletePosyandu($id)
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
        $query = "SELECT id_jadwal_posyandu FROM jadwal_posyandu ORDER BY id_jadwal_posyandu DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_jadwal_posyandu'])) {
                $lastId = $row['id_jadwal_posyandu'];

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
}
