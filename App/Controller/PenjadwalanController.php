<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\AnakModel;
use App\Model\ImunisasiModel;
use App\Model\PenjadwalanModel;
use App\Model\PertumbuhanModel;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class PenjadwalanController
{

    private AdminModel $adminModel;
    private PenjadwalanModel $penjadwalanModel;
    private AnakModel $anakModel;
    private ImunisasiModel $imunisasiModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->penjadwalanModel = new PenjadwalanModel();
        $this->anakModel = new AnakModel();
        $this->imunisasiModel = new ImunisasiModel();
    }

    // Imunisasi
    public function index()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $penjadwalan = $this->penjadwalanModel->findAllPenjadwalan();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/index", ["penjadwalan" => $penjadwalan]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function create()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $imunisasi = $this->imunisasiModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/create", ["anak" => $anak, "imunisasi" => $imunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function store(): void
    {
        $data = [
            "id_anak" => $_POST["nama_anak"],
            "id_jenis_imunisasi" => $_POST["nama_imunisasi"],
            "tanggal_imunisasi" => $_POST["tanggal_imunisasi"],
            "usia_pemberian" => $_POST["usia_pemberian"],
            "nama_bidan" => $_POST["nama_bidan"],
            "tempat_imunisasi" => $_POST["tempat_imunisasi"],
            "status_imunisasi" => $_POST["status_imunisasi"],
        ];


        if ($this->penjadwalanModel->insertDataImunisasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Jadwal Imunisasi!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan Jadwal Imunisasi!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        }
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Orang Tua";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $imunisasi = $this->imunisasiModel->findAll();
        $penjadwalan = $this->penjadwalanModel->findAllPenjadwalanById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/penjadwalan/edit", ["penjadwalan" => $penjadwalan, "anak" => $anak, "imunisasi" => $imunisasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "id_jadwal_imunisasi" => $_POST["id_jadwal_imunisasi"],
            "id_jenis_imunisasi" => $_POST["nama_imunisasi"],
            "tanggal_imunisasi" => $_POST["tanggal_imunisasi"],
            "usia_pemberian" => $_POST["usia_pemberian"],
            "nama_bidan" => $_POST["nama_bidan"],
            "tempat_imunisasi" => $_POST["tempat_imunisasi"],
            "status_imunisasi" => $_POST["status_imunisasi"],
        ];

        if ($this->penjadwalanModel->updateJadwalImunisasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Jadwal Imunisasi!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update Jadwal Imunisasi!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        }
    }

    // Posyandu
    public function posyandu()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $penjadwalan = $this->penjadwalanModel->findAllPosyandu();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/posyandu", ["penjadwalan" => $penjadwalan]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function createPosyandu()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/createPosyandu");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function storePosyandu(): void
    {
        $data = [
            "nama_pos" => $_POST["nama_pos"],
            "tanggal" => $_POST["tanggal"],
            "jam" => $_POST["jam"],
        ];

        if ($this->penjadwalanModel->insertDataPosyandu($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        }
    }

    public function editPosyandu($id)
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $posyandu = $this->penjadwalanModel->findAllPosyanduBydId($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/editPosyandu", ["posyandu" => $posyandu]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function updatePosyandu(): void
    {
        $data = [
            "id_jadwal_posyandu" => $_POST["id_jadwal_posyandu"],
            "pos" => $_POST["nama_pos"],
            "tanggal" => $_POST["tanggal"],
            "jam" => $_POST["jam"],
        ];

        if ($this->penjadwalanModel->updateDataPosyandu($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        }
    }

    public function destroy(string $idJadwal)
    {
        if ($this->penjadwalanModel->deleteImunisasi($idJadwal)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan"));
            exit;
        }
    }

    public function destroyPosyandu(string $idJadwal)
    {
        if ($this->penjadwalanModel->deletePosyandu($idJadwal)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        }
    }
}
