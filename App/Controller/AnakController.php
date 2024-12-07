<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\AnakModel;
use App\Model\ImunisasiModel;
use App\Model\OrangTuaModel;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class AnakController
{

    private $adminModel;
    private $anakModel;
    private $orangTuaModel;
    private ImunisasiModel $imunisasiModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
        $this->anakModel = new AnakModel();
        $this->orangTuaModel = new OrangTuaModel();
        $this->imunisasiModel = new ImunisasiModel();
    }

    public function index()
    {
        $title = "Molita | Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "null";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $startNumber = ($page - 1) * $limit + 1;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $anak = $this->anakModel->findAllBySearch($search, $limit, $offset);
            $totalRows = $this->anakModel->getTotalRows($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $anak = $this->anakModel->getPaginationData($limit, $offset);
            $totalRows = $this->anakModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Anak/index", ["anak" => $anak, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function create(): void
    {
        $title = "Monila | Tambah Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "null";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $orangTuaModel = $this->orangTuaModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Anak/create", ["orangTua" => $orangTuaModel]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "nama_anak" => $_POST["nama_anak"],
            "tanggal_lahir" => $_POST["tanggal_lahir"],
            "tempat_lahir" => $_POST["tempat_lahir"],
            "jenis_kelamin" => $_POST["jenis_kelamin"],
            "id_orang_tua" => $_POST["id_orang_tua"],
        ];


        if ($this->anakModel->insertData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        }
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "null";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findById($id);
        $orangTuaModel = $this->orangTuaModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/anak/edit", ["anak" => $anak, "orangTua" => $orangTuaModel]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "id_anak" => $_POST["id_anak"],
            "nama_anak" => $_POST["nama_anak"],
            "tanggal_lahir" => $_POST["tanggal_lahir"],
            "tempat_lahir" => $_POST["tempat_lahir"],
            "jenis_kelamin" => $_POST["jenis_kelamin"],
            "id_orang_tua" => $_POST["id_orang_tua"],
        ];


        if ($this->anakModel->updateData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        }
    }

    public function view($id)
    {
        $title = "Molita | Data Anak";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminAnak";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $imunisasi = $this->imunisasiModel->findByIdAnak($id);
        $anak = $this->anakModel->findById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Anak/view", ["anak" => $anak, "imunisasi" => $imunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function destroy(string $idAnak)
    {
        if ($this->anakModel->deleteDataById($idAnak)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data anak!");
            header("Location: " . UrlHelper::route("/anak"));
            exit;
        }
    }
}
