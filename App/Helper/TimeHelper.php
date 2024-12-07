<?php

class TimeHelper
{

    public static function timeAgo($timestamp)
    {

        date_default_timezone_set("Asia/Jakarta");

        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;

        $seconds = abs($time_difference);
        $minutes      = round($seconds / 60);           // value 60 is seconds
        $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
        $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
        $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
        $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) days * 24 hours * 60 minutes * 60 sec
        $years        = round($seconds / 31553280);     // value 31553280 is 365.25 days * 24 hours * 60 minutes * 60 sec

        if ($seconds <= 60) {
            return "Baru saja"; // less than 1 minute ago
        } else if ($minutes <= 60) {
            return $minutes . " Menit yang lalu";
        } else if ($hours <= 24) {
            return $hours . " Jam yang lalu";
        } else if ($days <= 7) {
            return $days . " Hari yang lalu";
        } else if ($weeks <= 4.3) { // 4.3 == 30/7
            return $weeks . " Minggu yang lalu";
        } else if ($months <= 12) {
            return $months . " Bulan yang lalu";
        } else {
            return $years . " Tahun yang lalu";
        }
    }

    public static function formatTanggalIndonesia($timestamp)
    {
        // Mengatur zona waktu ke Jakarta (WIB)
        date_default_timezone_set('Asia/Jakarta');

        // Daftar nama hari dalam bahasa Indonesia
        $hari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        // Daftar nama bulan dalam bahasa Indonesia
        $bulan = [
            1 => 'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        // Konversi timestamp menjadi waktu
        $time = strtotime($timestamp);

        // Ambil nama hari, tanggal, bulan, tahun, dan waktu
        $namaHari = $hari[date('w', $time)];
        $tanggal = date('j', $time);
        $namaBulan = $bulan[(int)date('n', $time)];
        $tahun = date('Y', $time);
        $jam = date('H:i', $time);

        // Gabungkan semuanya menjadi format yang diinginkan
        return "$namaHari, $tanggal $namaBulan $tahun $jam WIB";
    }

    public static function formatTanggal($tanggal)
    {
        // Array bulan dalam bahasa Indonesia
        $bulanIndonesia = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Memecah tanggal menjadi bagian-bagian
        $tanggalArray = explode('-', $tanggal);

        // Pastikan format tanggal valid
        if (count($tanggalArray) === 3) {
            $tahun = $tanggalArray[0];
            $bulan = (int)$tanggalArray[1]; // Ubah ke integer untuk index bulan
            $hari = $tanggalArray[2];

            // Format menjadi "25 Desember 2024"
            return "{$hari} {$bulanIndonesia[$bulan]} {$tahun}";
        }

        // Jika format salah, kembalikan teks default
        return "Format tanggal tidak valid";
    }

    public static function formatWaktuIndonesia($waktu) {
        // Memecah waktu menjadi bagian-bagian
        $waktuArray = explode(':', $waktu);
    
        // Pastikan format waktu valid
        if (count($waktuArray) === 3) {
            $jam = (int)$waktuArray[0];
            $menit = $waktuArray[1];
            $detik = $waktuArray[2];
    
            // Tentukan waktu (Pagi/Siang/Sore/Malam)
            if ($jam >= 0 && $jam < 12) {
                $periode = "Pagi";
            } elseif ($jam >= 12 && $jam < 15) {
                $periode = "Siang";
            } elseif ($jam >= 15 && $jam < 18) {
                $periode = "Sore";
            } else {
                $periode = "Malam";
            }
    
            // Format menjadi "08:10 Pagi"
            return sprintf("%02d:%02d", $jam, $menit);
        }
    
        // Jika format salah, kembalikan teks default
        return "Format waktu tidak valid";
    }
    
}
