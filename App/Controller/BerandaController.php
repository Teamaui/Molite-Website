<?php

namespace App\Controller;

use App\Helper\ViewReader;

class BerandaController
{


    public function index()
    {
        $title = "Molita";

        ViewReader::view("/Beranda/index", ["title" => $title]);
    }
}
