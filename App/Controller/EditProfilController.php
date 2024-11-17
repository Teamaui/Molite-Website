<?php

namespace App\Controller;

use App\Helper\ViewReader;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class EditProfilController
{

    private $adminModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: " . UrlHelper::route("login"));
        }

        $this->adminModel = new AdminModel();
    }

    public function index(): void
    {
        $title = "Molita | Dashboard";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "stylePengaturanAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/PengaturanTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/PengaturanTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/PengaturanTemplate/sidebar");
        ViewReader::view("/Profile/index", ["admin" => $admin]);
        ViewReader::view("/Templates/PengaturanTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "oldFoto" => $_POST["oldFoto"],
            "foto" => $_FILES["foto"],
            "username" => $_POST["username"],
            "nik" => $_POST["nik"],
            "nama_admin" => $_POST["nama_admin"],
            "email" => $_POST["email"],
            "password_sekarang" => $_POST["password_sekarang"],
            "new_password" => $_POST["new_password"],
            "repeat_password" => $_POST["repeat_password"],
        ];
        if (isset($data["password_sekarang"]) && trim($data["password_sekarang"]) != "") {
            if ($data["new_password"] == $data["repeat_password"]) {
                $dataAdmin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
                if (password_verify($data["password_sekarang"], $dataAdmin["password"])) {
                    if ($this->adminModel->updatePassword($data)) {
                        FlashMessageHelper::set("pesan_sukses", "Berhasil update data profile!");
                        header("Location: " . UrlHelper::route("edit-profile"));
                    } else {
                        FlashMessageHelper::set("pesan_gagal", "Gagal update data profile!");
                        header("Location: " . UrlHelper::route("edit-profile"));
                    }
                } else {
                    FlashMessageHelper::set("pesan_gagal", "Gagal update data password salah!");
                    header("Location: " . UrlHelper::route("edit-profile"));
                }
            } else {
                FlashMessageHelper::set("pesan_gagal", "Gagal update data password tidak sama!");
                header("Location: " . UrlHelper::route("edit-profile"));
            }
        } else {
            if ($this->adminModel->updateData($data)) {
                FlashMessageHelper::set("pesan_sukses", "Berhasil update data profile!");
                header("Location: " . UrlHelper::route("edit-profile"));
            } else {
                FlashMessageHelper::set("pesan_gagal", "Gagal update data profile!");
                header("Location: " . UrlHelper::route("edit-profile"));
            }
        }
    }
}
