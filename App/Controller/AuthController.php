<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\OtpModel;
use FlashMessageHelper;
use Model\AdminModel;
use Model\SuperAdminModel;
use PathHelper;
use UrlHelper;

class AuthController
{
    private AdminModel $admin;
    private SuperAdminModel $superAdminModel;
    private OtpModel $otpModel;

    public function __construct()
    {
        $this->admin = new AdminModel();
        $this->superAdminModel = new SuperAdminModel();
        $this->otpModel = new OtpModel();

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

            if ($userSuperAdmin = $this->superAdminModel->findByEmail($nik_atau_email)) {
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
            } else {
                if ($userData = $this->admin->findAdminByUniqueNikOrEmail($nik_atau_email)) {
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
                        } else {
                            header("Location: " . PathHelper::getPath() . "/register");
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

        ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
        ViewReader::view("Auth/lupaSandi");
        ViewReader::view("Templates/AuthTemplate/auth_footer");
    }

    public function sendOtp()
    {
        $data = [
            "email" => $_POST["email"],
            "subject" => "Reset Kata Sandi Anda - Kode OTP Anda di Sini"
        ];

        if ($admin = $this->otpModel->sendEmail($data)) {
            FlashMessageHelper::set("pesan_sukses", "Kode OTP berhasil dikirim ke email Anda, Silakan periksa email tersebut untuk melanjutkan proses reset password");
            header("Location: " . PathHelper::getPath() . "/otp-lupa-sandi/" . $admin["id_admin"]);
        } else {
            header("Location: " . PathHelper::getPath() . "/lupa-sandi");
        }
    }

    public function otpLupaSandi($id): void
    {
        $title = "Molita | Register";
        $styleCss = "styleLupaSandi";

        if ($this->otpModel->getOtpAdminById($id)) {
            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/otpLupaSandi", ["idAdmin" => $id]);
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        } else {
            header("Location: " . PathHelper::getPath() . "/lupa-sandi");
        }
    }

    public function storeOtpLupaSandi()
    {
        $data = [
            "id_admin" => $_POST["id_admin"],
            "kodeOtp" => $_POST["1"] . $_POST["2"] . $_POST["3"] . $_POST["4"] . $_POST["5"] . $_POST["6"],
        ];

        if ($this->otpModel->cekOtp($data)) {
            $title = "Molita | Lupa Sandi";
            $styleCss = "styleAuthLogin";

            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/gantiSandi", ["idAdmin" => $data["id_admin"]]);
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        } else {
            FlashMessageHelper::set("pesan_gagal", "Kode OTP yang anda masukkan salah!");
            header("Location: " . PathHelper::getPath() . "/otp-lupa-sandi/" . $data["id_admin"]);
        }
    }

    public function gantiSandi(): void
    {
        $data = [
            "id_admin" => $_POST["id_admin"],
            "sandi1" => $_POST["sandi1"],
            "sandi2" => $_POST["sandi2"],
        ];

        if ($data["sandi1"] == $data["sandi2"]) {
            if ($this->otpModel->updateSandiAdmin($data)) {
                FlashMessageHelper::set("pesan_register_sukses", "Sandi berhasil diperbarui! Silakan login!");
                header("Location: " . PathHelper::getPath() . "/login");
                exit;
            } else {
                FlashMessageHelper::set("pesan_login_gagal", "Sandi salah");
                header("Location: " . PathHelper::getPath() . "/login");
            }
        } else {
            FlashMessageHelper::set("pesan_gagal", "Sandi tidak sama! Coba lagi!");

            $title = "Molita | Lupa Sandi";
            $styleCss = "styleAuthLogin";

            ViewReader::view("Templates/AuthTemplate/auth_header", ["title" => $title, "styleCss" => $styleCss]);
            ViewReader::view("Auth/gantiSandi", ["idAdmin" => $data["id_admin"]]);
            ViewReader::view("Templates/AuthTemplate/auth_footer");
        }
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: " . UrlHelper::route("login"));
    }
}
