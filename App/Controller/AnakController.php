<?php

namespace App\Controller;

use App\Helper\ViewReader;
use Model\AdminModel;

class AnakController
{

    private $adminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $title = "Molita | Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminAnak";

        $admin = $this->adminModel->findAdminByUnique($_SESSION["nik"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Anak/index");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function create(): void
    {
        $title = "Monila | Tambah Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminAnak";

        $admin = $this->adminModel->findAdminByUnique($_SESSION["nik"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Anak/create");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
}
