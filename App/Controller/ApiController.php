<?php

namespace App\Controller;

use App\Model\OrangTuaModel;
use App\Model\PertumbuhanModel;

class ApiController
{
    private array $respon;
    private OrangTuaModel $orangTuaModel;
    private PertumbuhanModel $pertumbuhanModel;

    public function __construct()
    {
        $this->orangTuaModel = new OrangTuaModel();
        $this->pertumbuhanModel = new PertumbuhanModel();
    }


    public function getOrangTua()
    {
        if ($data = $this->orangTuaModel->findAll()) {
            $this->respon = [
                "code" => "200",
                "status" => "Berhasil Ambil Data Orang Tua",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "status" => "Gagal Ambil Data Orang Tua",
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
                "status" => "Berhasil Ambil Data Pertumbuhan",
                "data" => $data
            ];
        } else {
            $this->respon = [
                "code" => "401",
                "status" => "Gagal Ambil Data Pertumbuhan",
                "data" => ""
            ];
        }

        print json_encode($this->respon);
        exit;
    }
}
