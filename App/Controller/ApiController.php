<?php

namespace App\Controller;

use App\Helper\generateCodeHelper;
use App\Model\DashboardModel;
use App\Model\EdukasiModel;
use App\Model\OrangTuaModel;
use App\Model\PertumbuhanModel;
use Model\AdminModel;

class ApiController
{
    private array $respon;
    private OrangTuaModel $orangTuaModel;
    private PertumbuhanModel $pertumbuhanModel;
    private DashboardModel $dashboardModel;
    private EdukasiModel $edukasiModel;
    private AdminModel $adminModel;

    public function __construct()
    {
        $this->orangTuaModel = new OrangTuaModel();
        $this->pertumbuhanModel = new PertumbuhanModel();
        $this->dashboardModel = new DashboardModel();
        $this->edukasiModel = new EdukasiModel();
        $this->adminModel = new AdminModel();
    }

    public function registerOrangTua()
    {

        $nik = $_POST["nik"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $dataOrangTua = [
            "nik" => $nik,
            "username" => $username,
            "password" => $passwordHash,
            "token" => generateCodeHelper::generateToken(),
        ];

        if ($data = $this->orangTuaModel->registerOrangTua($dataOrangTua)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Register Data Orang Tua",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Register Data Orang Tua",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function loginOrangTua()
    {

        $nik = $_POST["nik"];
        $password = $_POST["password"];

        $dataOrangTua = [
            "nik" => $nik,
            "password" => $password,
        ];

        if ($data = $this->orangTuaModel->loginOrangTua($dataOrangTua)) {
            if (password_verify($password, $data["password"])) {
                if ($data["status_aktivasi"] == "Aktif") {
                    $this->respon = [
                        "code" => "200",
                        "success" => true,
                        "message" => "Berhasil Login Data Orang Tua",
                        "data" => $data
                    ];
                } else {
                    $this->respon = [
                        "code" => "400",
                        "success" => false,
                        "message" => "Gagal Login Akun Tidak Aktif",
                        "data" => ""
                    ];
                }
            } else {
                $this->respon = [
                    "code" => "400",
                    "success" => false,
                    "message" => "Gagal Login Password Akun Salah",
                    "data" => ""
                ];
            }
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Login Data Orang Tua",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getOrangTua()
    {
        if ($data = $this->orangTuaModel->findAll()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Orang Tua",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Orang Tua",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getPertumbuhan()
    {
        if ($data = $this->pertumbuhanModel->getAllPertumbuhanForMouth()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Pertumbuhan",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Pertumbuhan",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getPertumbuhanById($idAnak)
    {
        if ($data = $this->pertumbuhanModel->getAllPertumbuhanForMouthById($idAnak)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Pertumbuhan",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Pertumbuhan",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getStatusImunisasi()
    {
        if ($data = $this->dashboardModel->getStatusImunisasi()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Pertumbuhan",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Pertumbuhan",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function likeUserEdukasi()
    {

        $data = [
            "like_user" => $_POST["like_user"],
            "id_edukasi" => $_POST["id_edukasi"],
        ];

        if ($data = $this->edukasiModel->updateLikeEdukasi($data)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Data di update",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Data di update",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getDataEdukasi()
    {
        if ($data = $this->edukasiModel->getAllEdukasi()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Edukasi",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Edukasi",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }


    public function getDataAdminById($id)
    {
        if ($data = $this->adminModel->findAdminByUniqueId($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Admin",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Admin",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getDataOrangTuaById($id)
    {
        if ($data = $this->orangTuaModel->findById($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Orang Tua",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Orang Tua",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }
}
