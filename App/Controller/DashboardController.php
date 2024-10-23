<?php

namespace App\Controller;

use App\Helper\ViewReader;
use Model\AdminModel;

class DashboardController
{

    private $adminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
    }

    public function index(): void
    {
        $title = "Molita | Dashboard";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "none";

        $admin = $this->adminModel->findAdminByUnique($_SESSION["nik"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar");
        ViewReader::view("/Dashboard/index");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
}
