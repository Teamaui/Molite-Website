<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\DashboardModel;
use Model\AdminModel;
use Model\SuperAdminModel;
use UrlHelper;

class DashboarSuperController
{

    private $adminModel;
    private $dashboardModel;
    private $superAdminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk_super_admin"]) && $_SESSION["status_masuk_super_admin"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
        $this->superAdminModel = new SuperAdminModel();
        $this->dashboardModel = new DashboardModel();
    }

    public function index(): void
    {
        $title = "Molita | Dashboard";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleDashboard";
        $styleCss4 = "styleMediaSuperAdmin";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);
        $totalData = $this->dashboardModel->getAllRowsData();
        $statusImunisasi = $this->dashboardModel->getStatusImunisasi();

        ViewReader::view("/Templates/SuperAdminTemplate/header", ["title" => $title, "styleCss" => $styleCss, 'styleCss2' => $styleCss2, 'styleCss4' => $styleCss4]);
        ViewReader::view("/Templates/SuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/SuperAdminTemplate/sidebar");
        ViewReader::view("/Dashboard/index", ["superAdmin" => $superAdmin, "totalData" => $totalData, "statusImunisasi" => $statusImunisasi]);
        ViewReader::view("/Templates/SuperAdminTemplate/footer");
    }
}
