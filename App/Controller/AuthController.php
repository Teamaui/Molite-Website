<?php

namespace App\Controller;

use App\Helper\ViewReader;
use FlashMessageHelper;
use Model\AdminModel;
use Model\SuperAdminModel;
use PathHelper;
use UrlHelper;

class AuthController
{
    private AdminModel $admin;
    private SuperAdminModel $superAdminModel;

    public function __construct()
    {
        $this->admin = new AdminModel();
        $this->superAdminModel = new SuperAdminModel();

        if (isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == true) {
            header("Location: " . UrlHelper::route("dashboard"));
        }
    }

    public function index(): void
    {
        $title = "Molita | Login";
        $styleCss = "styleAuthLogin";

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/login");
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        } else {
            $nik_atau_email = $_POST["nik_atau_email"];
            $sandi = $_POST["sandi"];   
            
            if ($userSuperAdmin = $this->superAdminModel->findByEmail($nik_atau_email)){
                if (password_verify($sandi, $userSuperAdmin["password"])) {
                    FlashMessageHelper::set("pesan_login_sukses", "Berhasil login akun");
                    $_SESSION["nama_pengguna"] = $userSuperAdmin["nama"];
                    $_SESSION["email_super_admin"] = $userSuperAdmin["email"];
                    $_SESSION["status_masuk_super_admin"] = true;
                    header("Location: " . PathHelper::getPath() . "/dashboard-super-admin");
                    exit;
                } else {
                    FlashMessageHelper::set("pesan_login_gagal", "Sandi salah");
                    header("Location: " . PathHelper::getPath() . "/login");
                }
            }else{
                if ($userData = $this->admin->findAdminByUniqueNik($nik_atau_email)) {
                    if (password_verify($sandi, $userData["password"])) {
                        FlashMessageHelper::set("pesan_login_sukses", "Berhasil login akun");
                        $_SESSION["username"] = $userData["username"];
                        $_SESSION["id_admin"] = $userData["id_admin"];
                        $_SESSION["nik"] = $userData["nik"];
                        $_SESSION["status_masuk"] = true;
                        header("Location: " . PathHelper::getPath() . "/dashboard");
                        exit;
                    } else {
                        FlashMessageHelper::set("pesan_login_gagal", "Sandi salah");
                        header("Location: " . PathHelper::getPath() . "/login");
                    }
                } else {
                    FlashMessageHelper::set("pesan_login_gagal", "NIK tidak terdaftar");
                    header("Location: " . PathHelper::getPath() . "/login");
                }  
            }
        }
    }

    public function register(): void
    {
        $title = "Molita | Register";
        $styleCss = "styleAuthRegister";

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/register");
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        } else {
            if ($_POST["sandi1"] == $_POST["sandi2"]) {
                $data = [
                    "nik" => $_POST["nik"],
                    "username" => $_POST["username"],
                    "email" => $_POST["email"],
                    "sandi1" => $_POST["sandi1"],
                    "sandi2" => $_POST["sandi2"],
                ];

                if ($admin = $this->admin->findAdminByUniqueNik($data["nik"])) {
                    if ($admin["status_aktivasi"] != "Aktif") {
                        if ($this->admin->insertAdmin($data)) {
                            FlashMessageHelper::set("pesan_register_sukses", "Berhasil membuat akun! silahkan login");
                            header("Location: " . PathHelper::getPath() . "/login");
                            exit;
                        }
                    } else {
                        FlashMessageHelper::set("pesan_register_gagal", "Akun Sudah Aktif Silahkan Masuk");
                        header("Location: " . PathHelper::getPath() . "/register");
                    }
                } else {
                    FlashMessageHelper::set("pesan_register_gagal", "Akun Tidak Terdaftar");
                    header("Location: " . PathHelper::getPath() . "/register");
                }
            } else {
                FlashMessageHelper::set("pesan_register_gagal", "Password tidak sama");
                header("Location: " . PathHelper::getPath() . "/register");
            }
        }
    }

    public function lupaSandi(): void
    {
        $title = "Molita | Lupa Sandi";
        $styleCss = "styleAuthLogin";

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/lupaSandi");
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        } else {
            $nik = $_POST["nik"];
            $sandi = $_POST["sandi"];

            if ($userData = $this->admin->findAdminByUniqueNik($nik)) {
                if (password_verify($sandi, $userData["password"])) {
                    FlashMessageHelper::set("pesan_login_sukses", "Berhasil login akun");
                    $_SESSION["username"] = $userData["username"];
                    $_SESSION["id_admin"] = $userData["id_admin"];
                    $_SESSION["status_masuk"] = true;
                    header("Location: " . PathHelper::getPath() . "/dashboard");
                    exit;
                } else {
                    FlashMessageHelper::set("pesan_login_gagal", "Sandi salah");
                    header("Location: " . PathHelper::getPath() . "/login");
                }
            } else {
                FlashMessageHelper::set("pesan_login_gagal", "NIK tidak terdaftar");
                header("Location: " . PathHelper::getPath() . "/login");
            }
        }
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: " . UrlHelper::route("login"));
    }
}
