<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\ImunisasiModel;
use App\Model\PertumbuhanModel;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class LaporanController
{

    private $adminModel;
    private PertumbuhanModel $pertumbuhanModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->pertumbuhanModel = new PertumbuhanModel();
    }

    public function index()
    {
        $title = "Molita | Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminLaporan";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $data = [
            "page" => $page,
            "limit" => $limit,
            "offset" => $offset,
        ];
        if (isset($_GET["start_date"]) && isset($_GET["end_date"])) {
            $data["start_date"] = $_GET["start_date"];
            $data["end_date"] = $_GET["end_date"];
            $pertumbuhan = $this->pertumbuhanModel->getPaginationByDate($data);
            $totalRows = $this->pertumbuhanModel->getTotalRowsByDate($_GET["start_date"], $_GET["end_date"]);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $pertumbuhan = $this->pertumbuhanModel->getPaginationData($limit, $offset);
            $totalRows = $this->pertumbuhanModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $startNumber = ($page - 1) * $limit + 1;

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/laporan/index", ["pertumbuhan" => $pertumbuhan, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
}
