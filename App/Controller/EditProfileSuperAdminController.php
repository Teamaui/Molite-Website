<?php

namespace App\Controller;

use App\Helper\ViewReader;
use FlashMessageHelper;
use Model\AdminModel;
use Model\SuperAdminModel;
use UrlHelper;

class EditProfileSuperAdminController
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

    public function index(): void
    {
        $title = "Molita | Dashboard";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "stylePengaturanAdmin";

        $superAdmin = $this->superAdminModel->findByEmail($_SESSION["email_super_admin"]);

        ViewReader::view("/Templates/PengaturanSuperAdminTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/PengaturanSuperAdminTemplate/topbar", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/PengaturanSuperAdminTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/ProfileSuperAdmin/index", ["superAdmin" => $superAdmin]);
        ViewReader::view("/Templates/PengaturanSuperAdminTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "oldFoto" => $_POST["oldFoto"],
            "foto" => $_FILES["foto"],
            "email" => $_POST["email"],
            "nama" => $_POST["nama"],
            "alamat" => $_POST["alamat"],
            "password_sekarang" => $_POST["password_sekarang"],
            "new_password" => $_POST["new_password"],
            "repeat_password" => $_POST["repeat_password"],
        ];
        if (isset($data["password_sekarang"]) && trim($data["password_sekarang"]) != "") {
            if ($data["new_password"] == $data["repeat_password"]) {
                $dataSuperAdmin = $this->superAdminModel->findSuperAdminByUniqueId($_SESSION["id_super_admin"]);
                if (password_verify($data["password_sekarang"], $dataSuperAdmin["password"])) {
                    if ($this->superAdminModel->updatePassword($data)) {
                        FlashMessageHelper::set("pesan_sukses", "Berhasil update data profile!");
                        header("Location: " . UrlHelper::route("edit-profile-super-admin"));
                    } else {
                        FlashMessageHelper::set("pesan_gagal", "Gagal update data profile!");
                        header("Location: " . UrlHelper::route("edit-profile-super-admin"));
                    }
                } else {
                    FlashMessageHelper::set("pesan_gagal", "Gagal update data password salah!");
                    header("Location: " . UrlHelper::route("edit-profile-super-admin"));
                }
            } else {
                FlashMessageHelper::set("pesan_gagal", "Gagal update data password tidak sama!");
                header("Location: " . UrlHelper::route("edit-profile-super-admin"));
            }
        } else {
            if ($this->superAdminModel->updateData($data)) {
                FlashMessageHelper::set("pesan_sukses", "Berhasil update data profile!");
                header("Location: " . UrlHelper::route("edit-profile-super-admin"));
            } else {
                FlashMessageHelper::set("pesan_gagal", "Gagal update data profile!");
                header("Location: " . UrlHelper::route("edit-profile-super-admin"));
            }
        }
    }
}
