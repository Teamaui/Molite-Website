<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\AnakModel;
use App\Model\PertumbuhanModel;
use FlashMessageHelper;
use Model\AdminModel;
use UrlHelper;

class PertumbuhanController
{

    private AdminModel $adminModel;
    private PertumbuhanModel $pertumbuhanModel;
    private AnakModel $anakModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->pertumbuhanModel = new PertumbuhanModel();
        $this->anakModel = new AnakModel();
    }

    public function index()
    {
        $title = "Molita | Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $startNumber = ($page - 1) * $limit + 1;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $pertumbuhan = $this->pertumbuhanModel->findAllBySearch($search, $limit, $offset);
            $totalRows = $this->pertumbuhanModel->getTotalRows($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $pertumbuhan = $this->pertumbuhanModel->getPaginationData($limit, $offset);
            $totalRows = $this->pertumbuhanModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Pertumbuhan/index", ["pertumbuhan" => $pertumbuhan, "pagination" => $pagination, "startNumber" => $startNumber]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }
    public function create()
    {
        $title = "Molita | Tambah Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $pertumbuhan = $this->pertumbuhanModel->findAll();

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Pertumbuhan/create", ["pertumbuhan" => $pertumbuhan, "anak" => $anak]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "id_anak" => $_POST["nama_anak"],
            "tanggal_catat" => $_POST["tanggal_catat"],
            "berat_badan" => $_POST["berat_badan"],
            "tinggi_badan" => $_POST["tinggi_badan"],
            "lingkar_kepala" => $_POST["lingkar_kepala"],
        ];

        if ($this->pertumbuhanModel->insertData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Pertumbuhan!");
            header("Location: " . UrlHelper::route("/pertumbuhan"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan Pertumbuhan!");
            header("Location: " . UrlHelper::route("/pertumbuhan"));
            exit;
        }
    }

    public function edit($id)
    {
        $title = "Molita | Edit Data Pertumbuhan";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss4 = "styleMediaAdmin";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $anak = $this->anakModel->findAll();
        $pertumbuhan = $this->pertumbuhanModel->findById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss4" => $styleCss4]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Pertumbuhan/edit", ["pertumbuhan" => $pertumbuhan, "anak" => $anak]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function update(): void
    {
        $data = [
            "id_pertumbuhan" => $_POST["id_pertumbuhan"],
            "id_anak" => $_POST["nama_anak"],
            "tanggal_catat" => $_POST["tanggal_catat"],
            "berat_badan" => $_POST["berat_badan"],
            "tinggi_badan" => $_POST["tinggi_badan"],
            "lingkar_kepala" => $_POST["lingkar_kepala"],
        ];


        if ($this->pertumbuhanModel->updateData($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Pertumbuhan!");
            header("Location: " . UrlHelper::route("/pertumbuhan"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update Pertumbuhan!");
            header("Location: " . UrlHelper::route("/pertumbuhan"));
            exit;
        }
    }

    public function destroy(string $idPertumbuhan)
    {
        if ($this->pertumbuhanModel->deleteDataById($idPertumbuhan)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data Pertumbuhan!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data Pertumbuhan!");
            header("Location: " . UrlHelper::route("/orang-tua"));
            exit;
        }
    }
}
