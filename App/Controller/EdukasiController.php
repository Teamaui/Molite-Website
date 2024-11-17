<?php

use App\Helper\ViewReader;
use App\Model\EdukasiModel;
use Model\AdminModel;

class EdukasiController
{

    private AdminModel $adminModel;
    private EdukasiModel $edukasiModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->adminModel = new AdminModel();
        $this->edukasiModel = new EdukasiModel();
    }

    public function index()
    {
        $title = "Molita | Data Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 1;
        $offset = ($page - 1) * $limit;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $edukasi = $this->edukasiModel->findAllBySearch($search, $limit, $offset);
            $totalRows = $this->edukasiModel->getTotalRows($search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $edukasi = $this->edukasiModel->getPaginationData($limit, $offset);
            $totalRows = $this->edukasiModel->getTotalRows();
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/index", ["edukasi" => $edukasi, "pagination" => $pagination]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function create()
    {
        $title = "Molita | Tambah Jenis Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/create");
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function store(): void
    {
        $data = [
            "nama_edukasi" => $_POST["nama_edukasi"],
        ];

        if ($this->edukasiModel->insertDataJenisEdukasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Edukasi!");
            header("Location: " . UrlHelper::route("/edukasi"));
            exit;
        } else {
            header("Location: " . UrlHelper::route("/edukasi/create"));
            exit;
        }
    }

    public function detailJenis($id)
    {
        $title = "Molita | Data Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $jenisEdukasi = $this->edukasiModel->findJenisEdukasiById($id);

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 1;
        $offset = ($page - 1) * $limit;

        if (isset($_GET["search"])) {
            $search = '%' . $_GET["search"] . '%';
            $edukasi = $this->edukasiModel->findAllBySearchById($id, $search, $limit, $offset);
            $totalRows = $this->edukasiModel->getTotalRowsById($id, $search);
            $totalPages = ceil($totalRows / $limit);
        } else {
            $edukasi = $this->edukasiModel->getPaginationDataById($id, $limit, $offset);
            $totalRows = $this->edukasiModel->getTotalRowsById($id);
            $totalPages = ceil($totalRows / $limit);
        }

        $pagination = [
            'totalRows' => $totalRows,
            'totalPages' => $totalPages
        ];

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/detailJenis", ["edukasi" => $edukasi, "jenisEdukasi" => $jenisEdukasi, "pagination" => $pagination]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function storeDetailJenis()
    {
        $data = [
            "oldFoto" => $_POST["oldFoto"],
            "id_jenis_edukasi" => $_POST["id_jenis_edukasi"],
            "judul_edukasi" => $_POST["judul_edukasi"],
            "deskripsi_edukasi" => $_POST["deskripsi_edukasi"],
            "foto" => $_FILES["foto"],
        ];

        if ($this->edukasiModel->insertDataEdukasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menambahkan data Edukasi!");
            header("Location: " . UrlHelper::route("edukasi/detail-edukasi/" . $data["id_jenis_edukasi"]));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menambahkan Edukasi!");
            header("Location: " . UrlHelper::route("edukasi/detail-edukasi/" . $data["id_jenis_edukasi"]));
            exit;
        }
    }

    public function view($id)
    {
        $title = "Molita | Data Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $idJenisEdukasi = $id;
        $edukasi = $this->edukasiModel->findEdukasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/view", ["edukasi" => $edukasi, "idJenisEdukasi" => $idJenisEdukasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function editJenis($id)
    {
        $title = "Molita | Edit Jenis Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $jenisEdukasi = $this->edukasiModel->findJenisEdukasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/editJenis", ["jenisEdukasi" => $jenisEdukasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function updateJenis()
    {
        $data = [
            "id_jenis_edukasi" => $_POST["id_jenis_edukasi"],
            "nama_edukasi" => $_POST["nama_edukasi"],
        ];

        if ($this->edukasiModel->updateDataJenisEdukasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update jenis Edukasi!");
            header("Location: " . UrlHelper::route("edukasi"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update jenis Edukasi!");
            header("Location: " . UrlHelper::route("edukasi"));
            exit;
        }
    }

    public function editDetailEdukasi($id)
    {
        $title = "Molita | Edit Detail Edukasi";
        $styleCss = "styleMainAdmin";
        $styleCss2 = "styleAdminOne";
        $styleCss3 = "styleAdminMode";

        $admin = $this->adminModel->findAdminByUniqueId($_SESSION["id_admin"]);
        $edukasi = $this->edukasiModel->findEdukasiById($id);

        ViewReader::view("/Templates/DashboardTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2, "styleCss3" => $styleCss3]);
        ViewReader::view("/Templates/DashboardTemplate/topbar", ["admin" => $admin]);
        ViewReader::view("/Templates/DashboardTemplate/sidebar", ["title" => $title]);
        ViewReader::view("/Edukasi/editDetailEdukasi", ["edukasi" => $edukasi]);
        ViewReader::view("/Templates/DashboardTemplate/footer");
    }

    public function updateDetailEdukasi()
    {
        $data = [
            "oldFoto" => $_POST["oldFoto"],
            "id_jenis_edukasi" => $_POST["id_jenis_edukasi"],
            "id_edukasi" => $_POST["id_edukasi"],
            "judul_edukasi" => $_POST["judul_edukasi"],
            "deskripsi_edukasi" => $_POST["deskripsi_edukasi"],
            "foto" => $_FILES["foto"],
        ];

        if ($this->edukasiModel->updateDataDetailEdukasi($data)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil update data Edukasi!");
            header("Location: " . UrlHelper::route("edukasi/detail-edukasi/" . $data["id_jenis_edukasi"]));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal update Edukasi!");
            header("Location: " . UrlHelper::route("edukasi/detail-edukasi/" . $data["id_jenis_edukasi"]));
            exit;
        }
    }

    public function destroyDetailEdukasi($id)
    {
        if ($this->edukasiModel->deleteDetailEdukasi($id)) {
            FlashMessageHelper::set("pesan_sukses", "Berhasil menghapus data detail edukasi!");
            header("Location: " . UrlHelper::route("/edukasi"));
            exit;
        } else {
            FlashMessageHelper::set("pesan_gagal", "Gagal menghapus data detail edukasi!");
            header("Location: " . UrlHelper::route("/edukasi"));
            exit;
        }
    }
}
