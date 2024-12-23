<?php

namespace App\Controller;

use Model\AdminModel;
use App\Helper\ViewReader;
use App\Model\OrangTuaModel;
use App\Model\PenjadwalanModel;
use FlashMessageHelper;
use UrlHelper;

class OrangTuaController
{

    private AdminModel $adminModel;
    private OrangTuaModel $orangTuaModel;
    private PenjadwalanModel $penjadwalanPosyandu;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->orangTuaModel = new OrangTuaModel();
        $this->penjadwalanPosyandu = new PenjadwalanModel();
    }

    public function index()
    {
        $title = "Molita | Data Orang Tua";
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

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/OrangTua/index", ["orangTua" => $orangTua, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function create()
    {
        $title = "Molita | Tambah Data Orang Tua";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $posyandu = $this->penjadwalanPosyandu->findAllPosyandu();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/OrangTua/create", ["posyandu" =>$posyandu]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "email" => $_POST["email"],
            "nama_ibu" => $_POST["nama_ibu"],
            "nama_ayah" => $_POST["nama_ayah"],
            "nik_ibu" => $_POST["nik_ibu"],
            "nik_ayah" => $_POST["nik_ayah"],
            "alamat" => $_POST["alamat"],
            "nomor_telepon" => $_POST["nomor_telepon"],
            "id_jadwal_posyandu" => $_POST["id_posyandu"],
        ];

        if ($this->orangTuaModel->insertData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Orang Tua!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/orang-tua/create"));
            exit;
        }
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Orang Tua";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $orangTua = $this->orangTuaModel->findById($id);
        $posyandu = $this->penjadwalanPosyandu->findAllPosyandu();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/OrangTua/edit", ["orangTua" => $orangTua, "posyandu" => $posyandu]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "id_orang_tua" => $_POST["id_orang_tua"],
            "email" => $_POST["email"],
            "nama_ibu" => $_POST["nama_ibu"],
            "nama_ayah" => $_POST["nama_ayah"],
            "alamat" => $_POST["alamat"],
            "nik_ibu" => $_POST["nik_ibu"],
            "nik_ayah" => $_POST["nik_ayah"],
            "nomor_telepon" => $_POST["nomor_telepon"],
            "id_posyandu" => $_POST["id_posyandu"],
        ];

        if ($this->orangTuaModel->updateData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Orang Tua!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update Orang Tua!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        }
    }

    public function view($id)
    {
        $title = "Molita | Data Orang Tua";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminOrangTua";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        $orangTua = $this->orangTuaModel->findAllDataById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3,"styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/OrangTua/view", ["orangTua" => $orangTua]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function destroy(string $idOrangTua)
    {
        if ($this->orangTuaModel->deleteDataById($idOrangTua)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Orang Tua!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Orang Tua!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        }
    }
}
