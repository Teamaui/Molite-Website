<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\ImunisasiModel;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class ImunisasiController
{

    private $adminModel;
    private $imunisasiModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->imunisasiModel = new ImunisasiModel();
    }

    public function index()
    {
        $title = "Molita | Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $startNumber = ($page - 1) * $limit + 1;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $jenisImunisasi = $this->imunisasiModel->findAllBySearch($search, $limit, $offset);
            $totalRows = $this->imunisasiModel->getTotalRows($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $jenisImunisasi = $this->imunisasiModel->getPaginationData($limit, $offset);
            $totalRows = $this->imunisasiModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/index", ["jenisImunisasi" => $jenisImunisasi, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function create()
    {
        $title = "Molita | Tambah Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/create");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "nama_imunisasi" => $_POST["nama_imunisasi"],
            "deskripsi_imunisasi" => $_POST["deskripsi_imunisasi"],
        ];

        if ($this->imunisasiModel->insertData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/imunisasi/create"));
            exit;
        }
    }

    public function view($id)
    {
        $title = "Molita | Tambah Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $imunisasi = $this->imunisasiModel->findSearchViewById($id, $search, $limit, $offset);
            $totalRows = $this->imunisasiModel->getTotalRowsById($id, $search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $imunisasi = $this->imunisasiModel->getPaginationDataById($id, $limit, $offset);
            $totalRows = $this->imunisasiModel->getTotalRowsById($id);
            $totalPages = ceil($totalRows / $limit);
        }

        $startNumber = ($page - 1) * $limit + 1;

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        $jenisImunisasi = $this->imunisasiModel->findJenisImunisasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/view", ["imunisasi" => $imunisasi, "jenisImunisasi" => $jenisImunisasi, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";
        
        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $imunisasi = $this->imunisasiModel->findJenisImunisasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/edit", ["imunisasi" => $imunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "id_jenis_imunisasi" => $_POST["id_jenis_imunisasi"],
            "nama_imunisasi" => $_POST["nama_imunisasi"],
            "deskripsi_imunisasi" => $_POST["deskripsi_imunisasi"],
        ];

        if ($this->imunisasiModel->updateData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update data Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        }
    }

    public function destroy(string $idImunisasi)
    {
        if ($this->imunisasiModel->deleteImunisasiById($idImunisasi)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        }
    }
}
