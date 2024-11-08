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

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $jenisImunisasi = $this->imunisasiModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/index", ["jenisImunisasi" => $jenisImunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function create()
    {
        $title = "Molita | Tambah Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
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
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan Imunisasi!");
            header("Location: " . UrlHelper::route("/imunisasi"));
            exit;
        }
    }

    public function view($id)
    {
        $title = "Molita | Tambah Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $imunisasi = $this->imunisasiModel->findById($id);
        $jenisImunisasi = $this->imunisasiModel->findJenisImunisasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Imunisasi/view", ["imunisasi" => $imunisasi, "jenisImunisasi" => $jenisImunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Imunisasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $imunisasi = $this->imunisasiModel->findJenisImunisasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
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
}