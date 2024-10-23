<?php

namespace App\Helper;

use PDO;
use PDOException;

class DatabaseHelper {

    private static String $dbName = "monitoring_anak";
    private static String $host = "localhost";
    private static String $port = "3306";
    private static String $username = "root";
    private static String $password = "";

    public static function getConnection() : PDO {
        try {
            $dbh = new PDO("mysql:host=" . self::$host . ":" . self::$port . ";dbname=" . self::$dbName, self::$username, self::$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbh;
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    }
}