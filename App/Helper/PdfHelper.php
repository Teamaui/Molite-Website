<?php

class PdfHelper extends FPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk membuat header PDF
    public function header()
    {
        $this->SetX($this->GetX() + 3);
        $this->Image(UrlHelper::img('logo.png'), 30, 11, 13); 
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 12, 'LAPORAN PERTUMBUHAN ANAK', 0, 1, 'C');
        $this->Ln(1);
        $this->SetX($this->GetX() + 3);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 0, 'Alamat : Jln.Sumbersari No 3, Jember, Indonesia', 0, 1, 'C');
        $this->Ln(5);
        $this->SetX($this->GetX() + 3);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 0, 'Tlp : (+62) 895241640055 - Email : teamaui29@gmail.com', 0, 1, 'C');
        $this->Line(10, 34, 200, 34);
        $this->Ln(11);
    }

    // Fungsi untuk membuat footer PDF
    public function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    // Fungsi untuk membuat tabel data
    public function createTable($header, $data)
    {
        // Header tabel
        $this->SetTextColor(255, 255, 255);

        $this->Cell(10, 10, "No.", 1, 0, "C", true);
        foreach ($header as $col) {
            $this->Cell(36, 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Data tabel
        $this->SetTextColor(0, 0, 0);
        $i = 1;
        foreach ($data as $row) {
            $this->Cell(10, 10, $i++, 1, 0, "C");
            $this->Cell(36, 10, $row["nama_anak"], 1);
            $this->Cell(36, 10, $row["berat_badan"], 1, 0, "C");
            $this->Cell(36, 10, $row["tinggi_badan"], 1, 0, "C");
            $this->Cell(36, 10, $row["lingkar_kepala"], 1, 0, "C");
            $this->Cell(36, 10, $row["tanggal_pencatatan"], 1, 0, "C");
            $this->Ln();
        }
    }

    // Fungsi untuk output PDF
    public function outputPdf($filename = 'document.pdf')
    {
        $this->Output('I', $filename); // I untuk inline (buka di browser), D untuk unduh
    }
}
