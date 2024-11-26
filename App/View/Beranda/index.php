<?php

use Routes\Route;

$selectedJenisEdukasi = isset($_GET["jenisEdukasi"]) ? $_GET["jenisEdukasi"] : "";

?>





<main>
    <img src="<?= UrlHelper::img("assets/bg-corner.png") ?>" alt="" class="top">
    <div class="main-left">
        <div class="left">
            <h1>UNDUH APLIKASI MONITORING BALITA!</h1>
            <p>Ayo unduh aplikasi monitoring balita untuk memantau tumbuh kembang si kecil dengan mudah! Dapatkan fitur lengkap untuk mendukung perkembangan balita secara optimal.</p>
            <a href=""><i class="bi bi-arrow-right-circle-fill"></i> Unduh Sekarang, Pantau Lebih Mudah!</a>
        </div>
    </div>
    <div class="main-right">
        <img class="shake" src="<?= UrlHelper::img("lg1.png") ?>" alt="">
    </div>
</main>


<div class="layanan" id="layanan">
    <div class="container">
        <div class="left">
            <div class="top">
                <i class="bi bi-bar-chart-line"></i>
                <div class="container-teks">
                    <h3>Pantau Tumbuh Kembang dengan Lebih Detail</h3>
                    <p>Aplikasi ini membantu mencatat dan memantau perkembangan berat badan, tinggi badan, serta indikator kesehatan lain agar orang tua dapat memastikan tumbuh kembang anak sesuai standar.</p>
                </div>
            </div>
            <div class="bottom">
                <i class="bi bi-calendar-check"></i>
                <div class="container-teks">
                    <h3>Imunisasi Anak Lebih Terjadwal</h3>
                    <p>Dapatkan pengingat otomatis untuk semua jadwal imunisasi, sehingga Anda tidak akan melewatkan langkah penting dalam melindungi anak dari penyakit berbahaya.</p>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="top">
                <i class="bi bi-shield-lock"></i>
                <div class="container-teks">
                    <h3>Catatan Kesehatan Anak Tersimpan Aman</h3>
                    <p>Semua data kesehatan anak, mulai dari riwayat imunisasi hingga hasil pemeriksaan posyandu, tersimpan secara digital dan mudah diakses kapan saja.</p>
                </div>
            </div>
            <div class="bottom">
                <i class="bi bi-chat-dots"></i>
                <div class="container-teks">
                    <h3>Kemudahan Berkomunikasi dengan Posyandu</h3>
                    <p>Terhubung langsung dengan posyandu untuk mendapatkan informasi terkini, jadwal layanan, hingga konsultasi terkait kesehatan dan perkembangan anak.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="informasi-kesehatan" id="informasi">
    <div class="container">
        <h1>Informasi Kesehatan</h1>

        <div class="container-indi">

            <div class="container-card">
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/1.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/2.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/3.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/4.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/5.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/1.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/2.jpg") ?>" alt="">
                </div>
                <div class="card">
                    <img src="<?= UrlHelper::img("edukasi-beranda/3.jpg") ?>" alt="">
                </div>

                <button class="btn prev-btn">&#10094;</button>
                <button class="btn next-btn">&#10095;</button>
                <!-- Indikator -->
                <div class="indicators"></div>
            </div>

        </div>
    </div>
</div>

<div class="edukasi" id="edukasi">
    <div class="container">
        <h1>Edukasi Terkini</h1>

        <form action="" method="GET" class="filter-artikel">
            <button type="submit" name="jenisEdukasi" value="" class="<?= $selectedJenisEdukasi == "" ? "active" : "" ?>">Semua</button>
            <?php foreach ($jenisEdukasi as $jd) : ?>
                <button type="submit" name="jenisEdukasi" class="<?= $selectedJenisEdukasi == $jd["slug"] ? "active" : "" ?>" value="<?= $jd["slug"] ?>"><?= $jd["nama_edukasi"] ?></button>
            <?php endforeach; ?>
        </form>


        <?php $edukasiMain = $edukasi[0];
        unset($edukasi[0]); ?>
        <?php if ($edukasiMain["judul_edukasi"] != null) : ?>
            <div class="main-edukasi">
                <a href="<?= UrlHelper::route("edukasi/" . $edukasiMain["id_edukasi"]) ?>">
                    <img src="<?= UrlHelper::img("edukasi/" . $edukasiMain["img"]) ?>" alt="">
                    <h3><?= $edukasiMain["judul_edukasi"] ?></h3>
                    <p><?php
                        $teks = strip_tags($edukasiMain["deskripsi_edukasi"]);
                        $teks = explode(' ', $teks);

                        $deskripsiEdukasi = array_slice($teks, 0, 20);

                        echo implode(" ", $deskripsiEdukasi) . ".........";
                        ?></p>
                    <div class="link-a">
                        <a href="<?= UrlHelper::route("edukasi/" . $edukasiMain["id_edukasi"]) ?>">Baca selengkapnya</a>
                    </div>
                </a>
            </div>
        <?php else : ?>
            <div class="no-edukasi">
                <p>Edukasi belum tersedia!</p>
            </div>

        <?php endif; ?>

        <div class="sub-edukasi">
            <?php foreach ($edukasi as $edu) : ?>
                <a href="<?= UrlHelper::route("edukasi/" . $edu["id_edukasi"]) ?>" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi/" . $edu["img"]) ?>" alt="">
                    <div class="teks">
                        <h3><?= $edu["judul_edukasi"] ?></h3>
                        <p><?= TimeHelper::timeAgo($edu["created_at"]) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="data-posyandu" id="data">
    <div class="container">
        <div class="card-posyandu">
            <div class="sub-container">
                <div class="img">
                    <i class="bi bi-person-heart"></i>
                </div>
                <h3>Data Orang Tua</h3>
                <h1>10</h1>
            </div>
            <div class="sub-container">
                <div class="img img-2">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h3>Data Anak</h3>
                <h1>24</h1>
            </div>
            <div class="sub-container">
                <div class="img">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3>Jumlah Edukasi</h3>
                <h1>42</h1>
            </div>
        </div>
    </div>
</div>

<div class="footer">

    <div class="container">
        <div class="kolom">
            <h1><img src="<?= UrlHelper::img("lg-white.png") ?>" alt=""> Molita</h1>

            <h3>Tentang Kami</h3>
            <p>Molita adalah aplikasi untuk memantau tumbuh kembang anak, mencatat imunisasi, dan mendukung kesehatan buah hati Anda.</p>
        </div>
        <div class="kolom">
            <h3>Tautan</h3>

            <div class="links">
                <a href="#home">Home</a>
                <a href="#layanan">Layanan</a>
                <a href="#informasi">Informasi</a>
                <a href="#edukasi">Edukasi</a>
                <a href="#data">Data</a>
            </div>
        </div>

        <div id="map"></div>
    </div>
</div>