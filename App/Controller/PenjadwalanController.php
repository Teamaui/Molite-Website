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
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $startNumber = ($page - 1) * $limit + 1;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $penjadwalan = $this->penjadwalanModel->findAllBySearchImunisasi($search, $limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsImunisasi($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $penjadwalan = $this->penjadwalanModel->getPaginationDataImunisasi($limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsImunisasi();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/index", ["penjadwalan" => $penjadwalan, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function create()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $imunisasi = $this->imunisasiModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
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
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $imunisasi = $this->imunisasiModel->findAll();
        $penjadwalan = $this->penjadwalanModel->findAllPenjadwalanById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
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
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $startNumber = ($page - 1) * $limit + 1;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $posyandu = $this->penjadwalanModel->findAllBySearchPosyandu($search, $limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsPosyandu($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $posyandu = $this->penjadwalanModel->getPaginationDataPosyandu($limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsPosyandu();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/posyandu", ["posyandu" => $posyandu, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function createPosyandu()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/createPosyandu");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function storePosyandu(): void
    {
        $data = [
            "nama_pos" => $_POST["nama_pos"],
        ];

        if ($this->penjadwalanModel->insertDataPosyandu($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu"));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/create"));
            exit;
        }
    }

    public function editPosyandu($id)
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $posyandu = $this->penjadwalanModel->findPosyanduBydId($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/editPosyandu", ["posyandu" => $posyandu]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function updatePosyandu(): void
    {
        $data = [
            "id_posyandu" => $_POST["id_posyandu"],
            "pos" => $_POST["nama_pos"],
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

    public function viewPosyandu($id)
    {
        $title = "Molita | View Posyandu";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $posyandu = $this->penjadwalanModel->findAllBySearchPosyanduById($id, $search, $limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsPosyanduById($id, $search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $posyandu = $this->penjadwalanModel->getPaginationDataPosyanduById($id, $limit, $offset);
            $totalRows = $this->penjadwalanModel->getTotalRowsPosyanduById($id);
            $totalPages = ceil($totalRows / $limit);
        }

        $startNumber = ($page - 1) * $limit + 1;

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages,
            'id_posyandu' => $id
        ];

        $jenisPosyandu = $this->penjadwalanModel->findPosyanduBydId($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/jadwalPosyandu", ["posyandu" => $posyandu, "jenisPosyandu" => $jenisPosyandu, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function storeJadwalPosyandu(): void
    {
        $data = [
            "id_posyandu" => $_POST["id_posyandu"],
            "tanggal" => $_POST["tanggal"],
            "jam_mulai" => $_POST["jam_mulai"],
            "jam_selesai" => $_POST["jam_selesai"],
        ];
        if ($this->penjadwalanModel->insertDataJadwalPosyandu($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/view/" . $data["id_posyandu"]));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/create"));
            exit;
        }
    }

    public function editJadwalPosyandu($id)
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $jadwalPosyandu = $this->penjadwalanModel->findJadwalPosyanduBydId($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Penjadwalan/editJadwalPosyandu", ["jadwalPosyandu" => $jadwalPosyandu]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function updateJadwalPosyandu(): void
    {
        $data = [
            "id_jadwal_posyandu" => $_POST["id_jadwal_posyandu"],
            "id_posyandu" => $_POST["id_posyandu"],
            "tanggal" => $_POST["tanggal"],
            "jam_mulai" => $_POST["jam_mulai"],
            "jam_selesai" => $_POST["jam_selesai"],
        ];

        if ($this->penjadwalanModel->updateDataJadwalPosyandu($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil edit data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/view/" . $data["id_posyandu"]));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/create"));
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

    public function destroyJadwalPosyandu(string $idJadwal)
    {
        if ($this->penjadwalanModel->deleteJadwalPosyandu($idJadwal)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/view"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Jadwal Posyandu!");
            header("Location: " . UrlHelper::route("/penjadwalan/posyandu/view"));
            exit;
        }
    }
}
