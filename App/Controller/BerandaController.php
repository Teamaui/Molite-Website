<?php

namespace App\Controller;

use App\Helper\ViewReader;
use App\Model\EdukasiModel;

class BerandaController
{

    private EdukasiModel $edukasiModel;

    public function __construct()
    {
        $this->edukasiModel = new EdukasiModel();
    }

    public function index()
    {
        $title = "Molita";
        $styleCss = "styleBeranda";

        $getSlugEdukasi = isset($_GET["jenisEdukasi"]) ? $_GET["jenisEdukasi"] : '';

        if ($getSlugEdukasi) {
            $edukasi = $this->edukasiModel->findAllBySlug($getSlugEdukasi);
        } else {
            $edukasi = $this->edukasiModel->findAllEdukasi();
        }

        $jenisEdukasi = $this->edukasiModel->findAllJenisEdukasi();

        ViewReader::view("/Templates/BerandaTemplate/header", ["title" => $title, "styleCss" => $styleCss]);
        ViewReader::view("/Templates/BerandaTemplate/topbar");
        ViewReader::view("/Beranda/index", ["jenisEdukasi" => $jenisEdukasi, "edukasi" => $edukasi]);
        ViewReader::view("/Templates/BerandaTemplate/footer");
    }

    public function edukasi($idEdukasi)
    {
        $title = "Molita | Edukasi";
        $styleCss = "styleBeranda";
        $styleCss2 = "cssBerandaEdukasi";

        $edukasi = $this->edukasiModel->findEdukasiById($idEdukasi);

        ViewReader::view("/Templates/BerandaTemplate/header", ["title" => $title, "styleCss" => $styleCss, "styleCss2" => $styleCss2]);
        ViewReader::view("/Templates/BerandaTemplate/topbar");
        ViewReader::view("/Beranda/edukasi", ["edukasi" => $edukasi]);
        ViewReader::view("/Templates/BerandaTemplate/footer");
    }
}
