<?php

namespace App\Controller;

use App\Helper\generateCodeHelper;
use App\Model\AnakModel;
use App\Model\DashboardModel;
use App\Model\EdukasiModel;
use App\Model\ImunisasiModel;
use App\Model\OrangTuaModel;
use App\Model\OtpModel;
use App\Model\PenjadwalanModel;
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
    private PenjadwalanModel $penjadwalanModel;
    private AnakModel $anakModel;
    private ImunisasiModel $imunisasiModel;
    private OtpModel $otpModel;

    public function __construct()
    {
        $this->orangTuaModel = new OrangTuaModel();
        $this->pertumbuhanModel = new PertumbuhanModel();
        $this->dashboardModel = new DashboardModel();
        $this->edukasiModel = new EdukasiModel();
        $this->adminModel = new AdminModel();
        $this->penjadwalanModel = new PenjadwalanModel();
        $this->anakModel = new AnakModel();
        $this->imunisasiModel = new ImunisasiModel();
        $this->otpModel = new OtpModel();
    }

    public function registerOrangTua()
    {

        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $dataOrangTua = [
            "email" => $email,
            "username" => $username,
            "password" => $passwordHash,
            "token" => generateCodeHelper::generateToken(),
        ];

        if ($this->orangTuaModel->registerOrangTua($dataOrangTua)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Register Data Orang Tua",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Register Data Orang Tua",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function loginOrangTua()
    {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $dataOrangTua = [
            "email" => $email,
            "password" => $password,
        ];

        if ($data = $this->orangTuaModel->loginOrangTua($dataOrangTua)) {
            if (password_verify($password, $data["password"])) {
                if ($data["status_aktivasi"] == "Aktif") {
                    $this->respon = [
                        "code" => "200",
                        "success" => true,
                        "message" => "Berhasil Login Data Orang Tua",
                        "data" => [$data]
                    ];
                } else {
                    $this->respon = [
                        "code" => "400",
                        "success" => false,
                        "message" => "Gagal Login Akun Tidak Aktif",
                    ];
                }
            } else {
                $this->respon = [
                    "code" => "400",
                    "success" => false,
                    "message" => "Gagal Login Password Akun Salah",
                ];
            }
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Login Data Orang Tua",
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

    public function getDataJenisEdukasi()
    {
        if ($data = $this->edukasiModel->findAllJenisEdukasi()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Jenis Edukasi",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Jenis Edukasi",
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
            "id_orang_tua" => $_POST["id_orang_tua"],
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
                "code" => "200",
                "success" => true,
                "message" => "Gagal Data di update",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getLikeEdukasi()
    {
        $id = $_POST["id_orang_tua"];
        if ($data = $this->edukasiModel->getLikeEdukasi($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Data di update",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Data di update",
                "data" => ''
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getEdukasiNew()
    {
        if ($data = $this->edukasiModel->getEdukasiNew()) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil ambil data edukasi terbaru",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal ambil data edukasi terbaru",
                "data" => ''
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

    public function getDataEdukasiBySlug()
    {
        $slug = $_GET["slug"];
        if ($data = $this->edukasiModel->findAllBySlug($slug)) {
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

    public function getAnakByIdOrangTua()
    {
        $id = $_POST["id"];
        if ($data = $this->penjadwalanModel->getPenjadwalanAnak($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Anak",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Anak",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getPosyanduByIdOrangTua()
    {
        $id = $_POST["id"];
        if ($data = $this->penjadwalanModel->getPosyanduByIdOrangTua($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Anak",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Anak",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getImunisasiAnak()
    {
        $id = $_POST["id"];
        if ($data = $this->imunisasiModel->findByIdAnak($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Anak",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal Ambil Data Anak",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function getDataOrangTuaByIdToMobile()
    {
        $id = $_POST["id"];
        if ($data = $this->orangTuaModel->findById($id)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil Ambil Data Orang Tua",
                "data" => [$data]
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

    public function getPertumbuhanByAnak()
    {
        $idAnak = $_POST["id"];
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

    public function getAnakOrangTua()
    {
        $idAnak = $_POST["id"];
        if ($data = $this->anakModel->findByIdOrangTua($idAnak)) {
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

    public function getAllDataAnakByOrangTua()
    {
        $idOrangTua = $_POST["id"];
        if ($data = $this->anakModel->findAllDataByIdOrangTua($idOrangTua)) {
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

    public function getEdukasiOrderLike()
    {
        if ($data = $this->edukasiModel->findAllEdukasiOrderLike()) {
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

    public function sendEmailOrangTua()
    {

        $data = [
            "username" => $_POST["username"],
            "email" => $_POST["email"],
            "subject" => "Reset Kata Sandi Anda - Kode OTP Anda di Sini"
        ];

        if ($this->otpModel->sendEmailOrangTua($data)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil kirim Kode OTP",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Username atau Email Tidak Terdaftar",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function cekOtpOrangTua()
    {
        $kodeOtp = $_POST["kodeOtp"];
        $email = $_POST["email"];

        if ($this->otpModel->cekOtpOrangTua($kodeOtp, $email)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "OTP yang dimasukkan benar",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Kode OTP salah",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function ubahSandiOrangTua()
    {
        $data = [
            "kodeOtp" => $_POST["kodeOtp"],
            "email" => $_POST["email"],
            "password" => $_POST["password"]
        ];

        if ($this->otpModel->ubahSandiOrangTua($data)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil ganti sandi",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal ganti sandi",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    public function gantiSandiOrangTua()
    {
        $data = [
            "id_orang_tua" => $_POST["id_orang_tua"],
            "sandiLama" => $_POST["sandiLama"],
            "sandiBaru" => $_POST["sandiBaru"]
        ];

        if ($this->orangTuaModel->gantiSandi($data)) {
            $this->respon = [
                "code" => "200",
                "success" => true,
                "message" => "Berhasil ganti sandi",
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "success" => false,
                "message" => "Gagal ganti sandi",
            ];
        }

        print json_encode($this->respon);
        exit;
    }

    // public function getPenjadwalanImunisasi()
    // {
    //     if ($data = $this->penjadwalanModel->findJadwal()) {
    //         $this->respon = [
    //             "code" => "200",
    //             "success" => true,
    //             "message" => "Berhasil Ambil Data Penjadwalan",
    //             "data" => $data
    //         ];
    //     } else {
    //         $this->respon = [
    //             "code" => "401",
    //             "success" => false,
    //             "message" => "Gagal Ambil Data Penjadwalan",
    //             "data" => ""
    //         ];
    //     }

    //     print json_encode($this->respon);
    //     exit;
    // }
}
