<?php

namespace App\Controller;

use App\Model\PertumbuhanModel;
use PdfHelper;

class ReportController
{

    private PertumbuhanModel $pertumbuhanModel;

    public function __construct()
    {
        if (!isset($_SESSION["status_masuk"]) && $_SESSION["status_masuk"] == false) {
            header("Location: /login");
        }

        $this->pertumbuhanModel = new PertumbuhanModel();
    }

    public function generateReport()
    {

        // Pagination
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $data = [
            "page" => $page,
            "limit" => $limit,
            "offset" => $offset,
        ];
        if (isset($_GET["start_date"]) && isset($_GET["end_date"])) {
            $data["start_date"] = $_GET["start_date"];
            $data["end_date"] = $_GET["end_date"];
            $pertumbuhan = $this->pertumbuhanModel->getPaginationByDate($data);
        } else {
            $pertumbuhan = $this->pertumbuhanModel->getPaginationData($limit, $offset);
        }

        // Header untuk tabel di PDF
        $header = ['Nama Anak', 'Berat Badan (Gram)', 'Tinggi Badan (CM)', 'Lingkar Kepala (CM)', 'Tanggal Pencatatan'];

        // Buat PDF baru menggunakan PdfHelper
        $pdf = new PdfHelper();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 10);

        // Tambahkan tabel ke PDF
        $pdf->SetFillColor(9, 141, 179);
        $pdf->createTable($header, $pertumbuhan);

        // Output PDF
        $pdf->outputPdf('data_pertumbuhan.pdf');
    }
}
