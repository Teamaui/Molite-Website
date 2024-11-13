<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\DashboardModel;
use Model\AdminModel;
use UrlHelper;

class DashboardController
{

    private $adminModel;
    private $dashboardModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
        $this->dashboardModel = new DashboardModel();
    }

    public function index(): void
    {
        $title = "Molita | Dashboard";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleDashboard";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $totalData = $this->dashboardModel->getAllRowsData();
        $statusImunisasi = $this->dashboardModel->getStatusImunisasi();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, 'styleCss2' => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar");
        ViewReader::view("/Dashboard/index", ["admin" => $admin, "totalData" => $totalData, "statusImunisasi" => $statusImunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
}
