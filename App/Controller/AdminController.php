<?php

namespace App\Controller;

use Model\AdminModel;
use App\Helper\ViewReader;
use App\Model\OrangTuaModel;
use FlashMessageHelper;
use Model\SuperAdminModel;
use UrlHelper;

class AdminController
{
    private AdminModel $adminModel;
    private SuperAdminModel $superAdminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk_super_admin"]) && $_SESSION["status_masuk_super_admin"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
        $this->superAdminModel = new SuperAdminModel();
    }

    public function index()
    {
        $title = "Molita | Data Admin";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);
        $admin = $this->adminModel->findAll();

        ViewReader::view("/Templates/SuperAdminTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/SuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/SuperAdminTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Admin/index", ["admin" => $admin]);
        ViewReader::view("/Templates/SuperAdminTemplate/footer");
    }
    public function create()
    {
        $title = "Molita | Tambah Data Admin";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);

        ViewReader::view("/Templates/SuperAdminTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/SuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/SuperAdminTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Admin/create");
        ViewReader::view("/Templates/SuperAdminTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "nik" => $_POST["nik"],
            "nama_admin" => $_POST["nama_admin"],
            "email" => $_POST["email"],
        ];

        if ($this->adminModel->insertNewAdmin($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Admin!");
            header("Location: " . UrlHelper::route("/admin"));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/admin/create"));
            exit;
        }
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Admin";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);
        $admin = $this->adminModel->findAdminByUniqueId($id);

        ViewReader::view("/Templates/SuperAdminTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/SuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/SuperAdminTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Admin/edit", ["admin" => $admin]);
        ViewReader::view("/Templates/SuperAdminTemplate/footer");
    }

    // public function update(): void
    // {
    //     $data = [
    //         "id_orang_tua" => $_POST["id_orang_tua"],
    //         "email" => $_POST["email"],
    //         "nama_ibu" => $_POST["nama_ibu"],
    //         "nama_ayah" => $_POST["nama_ayah"],
    //         "alamat" => $_POST["alamat"],
    //         "nik_ibu" => $_POST["nik_ibu"],
    //         "nik_ayah" => $_POST["nik_ayah"],
    //         "nomor_telepon" => $_POST["nomor_telepon"],
    //     ];

    //     if ($this->orangTuaModel->updateData($data)) {
    //         FlashMessageHelper::set("pesan_sukses", "Berhasil update data Admin!");
    //         header("Location: " . UrlHelper::route("/orang-tua"));
    //         exit;
    //     } else {
    //         FlashMessageHelper::set("pesan_gagal", "Gagal update Admin!");
    //         header("Location: " . UrlHelper::route("/orang-tua"));
    //         exit;
    //     }
    // }

    // public function view($id)
    // {
    //     $title = "Molita | Data Admin";
    //     $styleCss = "styleMainAdmin";
    //     $styleCss2 = "styleAdminOne";
    //     $styleCss3 = "styleAdminOrangTua";

    //     $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

    //     $orangTua = $this->orangTuaModel->findAllDataById($id);

    //     ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
    //     ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
    //     ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
    //     ViewReader::view("/OrangTua/view", ["orangTua" => $orangTua]);
    //     ViewReader::view("/Templates/DashboardTemplate/footer");
    // }

    public function destroy(string $idAdmin)
    {
        if ($this->adminModel->deleteDataById($idAdmin)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Admin!");
            header("Location: " . UrlHelper::route("/admin"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Admin!");
            header("Location: " . UrlHelper::route("/admin"));
            exit;
        }
    }
}
