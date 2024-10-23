<?php

namespace Seeder;

use App\Helper\DatabaseHelper;

class MasterSeeder
{

    private $db;

    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function run() : void
    {

        // id_master | nik | nama_ketua | email_ketua | nama_posyandu | alamat_lengkap_posyandu | provinsi | password	
        $masters = [
            [
                "nik" => "1212", 
                "nama_ketua" => "Aisyah Hamda", 
                "email_ketua" => "hamdasaja@gmail.com",
                "nama_posyandu" => "Posyandu SiKecil", 
                "alamat_lengkap_posyandu" => "Jember - Mangli", 
                "provinsi" => "Jember"
            ],
        ];

        foreach ($masters as $master) {

            $sql = "INSERT INTO master VALUES(NULL, :nik, :nama_ketua, :email_ketua, :nama_posyandu, :alamat, :provinsi, NULL)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nik", $master["nik"]);
            $stmt->bindParam(":nama_ketua", $master["nama_ketua"]);
            $stmt->bindParam(":email_ketua", $master["email_ketua"]);
            $stmt->bindParam(":nama_posyandu", $master["nama_posyandu"]);
            $stmt->bindParam(":alamat", $master["alamat_lengkap_posyandu"]);
            $stmt->bindParam(":provinsi", $master["provinsi"]);

            if($stmt->execute()) {
                echo "Tabel Master " . $master["nama_ketua"] . " Berhasil di tambahkan" . PHP_EOL;
            } else {
                echo "Tabel Master " . $master["nama_ketua"] . " Gagal di tambahkan" . PHP_EOL;
            }
        }
    }

    public function rollback() : void {

        $sql = "DELETE FROM master WHERE email_ketua in ('hamdasaja@gmail.com')";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        if($stmt->rowCount()) {
            echo "Tabel Master Berhasil Dihapus" . PHP_EOL;
        } else {
            echo "Tabel Master Gagal Dihapus" . PHP_EOL;
        }

    }
}
