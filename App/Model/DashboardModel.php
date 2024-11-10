<?php

namespace App\Model;

use App\Helper\DatabaseHelper;
use PDO;

class DashboardModel
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function getAllRowsData()
    {
        $query = "SELECT * FROM vtotal_data";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($data as $row) {
            $result[] = $row["jumlah_data"];
        }
        return $result;
    }

    public function getStatusImunisasi()
    {
        $query = "SELECT 
            COUNT(CASE WHEN status_imunisasi = 'Sudah' THEN 1 END) AS jumlah_sudah,
            COUNT(CASE WHEN status_imunisasi = 'Tertunda' THEN 1 END) AS jumlah_tertunda,    
            COUNT(CASE WHEN status_imunisasi = 'Belum' THEN 1 END) AS jumlah_belum
        FROM jadwal_imunisasi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
