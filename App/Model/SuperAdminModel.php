<?php

namespace Model;

use App\Helper\DatabaseHelper;
use PDO;

class SuperAdminModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM super_admin WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

}
