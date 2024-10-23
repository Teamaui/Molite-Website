<?php

namespace Model;

use App\Helper\DatabaseHelper;
use PDO;

class AdminModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findAdminByUnique(string $nik)
    {
        $sql = "SELECT * FROM admin WHERE nik = :nik";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nik", $nik);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function insertAdmin(array $data): bool
    {
        $sandiAman = password_hash($data["sandi1"], PASSWORD_DEFAULT);

        $sql = "UPDATE admin SET username = :username, status_aktif = 1, sandi = :sandi WHERE nik = :nik";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":sandi", $sandiAman);
        $stmt->bindParam(":nik", $data["nik"]);

        return $stmt->execute();
    }
}
