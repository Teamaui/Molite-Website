<?php

namespace App\Controller;

use Model\AdminModel;
use App\Helper\ViewReader;
use App\Model\OrangTuaModel;
use FlashMessageHelper;
use Model\SuperAdminModel;
use UrlHelper;

class OrangTuaAdminController
{

    private AdminModel $adminModel;
    private OrangTuaModel $orangTuaModel;
    private SuperAdminModel $superAdminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk_super_admin"]) && $_SESSION["status_masuk_super_admin"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
        $this->orangTuaModel = new OrangTuaModel();
        $this->superAdminModel = new SuperAdminModel();
    }

    public function index()
    {
        $title = "Molita | Data Orang Tua";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);
        

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 1;
        $offset = ($page - 1) * $limit;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $orangTua = $this->orangTuaModel->findAllBySearch($search, $limit, $offset);
            $totalRows = $this->orangTuaModel->getTotalRows($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $orangTua = $this->orangTuaModel->getPaginationData($limit, $offset);
            $totalRows = $this->orangTuaModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/SuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/SuperAdminTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/orangTuaAdmin/index", ["orangTua" => $orangTua,"pagination" => $pagination]);
        ViewReader::view("/Templates/SuperAdminTemplate/footer");
    }
}
