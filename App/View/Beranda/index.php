<?php

use Routes\Route;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= UrlHelper::img("lg.png"); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= UrlHelper::css("styleBeranda") ?>">
    <title><?= $title ?></title>
</head>

<body id="home">
    <header class="topbar">
        <nav>
            <div class="left-nav">
                <a href=""><span class="mo">Mo</span><span class="lita">lita</span></a>
                <ul class="nav-links">
                    <li><a href="#home" class="nav-link home">Home</a></li>
                    <li><a href="#layanan" class="nav-link about">Layanan</a></li>
                    <li><a href="#informasi" class="nav-link service">Informasi</a></li>
                    <li><a href="#edukasi" class="nav-link contact">Edukasi</a></li>
                    <li><a href="#data" class="nav-link contact">Data</a></li>
                </ul>
            </div>
            <div class="login-btn">
                <a href="<?= UrlHelper::route("login") ?>">Masuk / Daftar</a>
            </div>
        </nav>
    </header>
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

            <div class="filter-artikel">
                <a href="" class="active">Semua</a>
                <a href="">Sensorik</a>
                <a href="">Motorik</a>
            </div>

            <div class="main-edukasi">
                <a href="">
                    <img src="<?= UrlHelper::img("edukasi-beranda/2.jpg") ?>" alt="">
                    <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                    <p>Kesehatan anak dan balita adalah hal yang sangat penting untuk memastikan tumbuh kembang mereka berjalan dengan optimal. Pada masa ini, anak membutuhkan perhatian khusus karena tubuhnya masih dalam proses berkembang...</p>
                    <div class="link-a">
                        <a href="">Baca selengkapnya</a>
                    </div>
                </a>
            </div>

            <div class="sub-edukasi">
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/1.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/2.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/3.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/4.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a><a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/5.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/1.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a><a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/2.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
                <a href="#" class="edukasi">
                    <img src="<?= UrlHelper::img("edukasi-beranda/3.jpg") ?>" alt="">
                    <div class="teks">
                        <h3>Menjaga Kesehatan Anak dan Balita: Tips untuk Orang Tua</h3>
                        <p>4 Menit yang lalu</p>
                    </div>
                </a>
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
        </div>
    </div>

    <div class="footer-bottom">
        <p>&#169; <?= date("Y") ?> Molita. Semua hak cipta dilindung.</p>
    </div>

    <script>
        window.addEventListener("scroll", function() {
            const topbar = document.querySelector(".topbar");
            let scrollPos = window.scrollY;

            if (scrollPos > 20) { // Jika discroll lebih dari 10px
                topbar.style.backdropFilter = "blur(10px)";
            } else {
                topbar.style.backdropFilter = "blur(0px)";
            }
        });

        const swiperContainer = document.querySelector(".container-card");
        const cards = document.querySelectorAll(".card");
        const prevBtn = document.querySelector(".prev-btn");
        const nextBtn = document.querySelector(".next-btn");
        const indicatorsContainer = document.querySelector(".indicators");

        // Konfigurasi jumlah kartu yang tampil
        const cardsPerView = 3; // Ubah angka ini untuk jumlah kartu yang ditampilkan
        const totalCards = cards.length;
        let currentIndex = 0;

        // Membuat indikator
        for (let i = 0; i < Math.ceil(totalCards / cardsPerView); i++) {
            const indicator = document.createElement("span");
            indicator.classList.add("indicator");
            if (i === 0) indicator.classList.add("active");
            indicatorsContainer.appendChild(indicator);
        }

        const indicators = document.querySelectorAll(".indicator");

        // Menampilkan kartu sesuai indeks
        function showCards(index) {
            const offset = index * cardsPerView;
            const containerWidth = swiperContainer.offsetWidth;
            const translateX = -offset * (containerWidth / cardsPerView);

            cards.forEach((card) => {
                card.style.transform = `translateX(${translateX}px)`;
            });

            updateIndicators(index);
        }

        // Memperbarui indikator
        function updateIndicators(index) {
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle("active", i === index);
            });
        }

        // Navigasi ke set kartu berikutnya
        function nextCards() {
            currentIndex = Math.min(
                currentIndex + 1,
                Math.ceil(totalCards / cardsPerView) - 1
            );
            showCards(currentIndex);
        }

        // Navigasi ke set kartu sebelumnya
        function prevCards() {
            currentIndex = Math.max(currentIndex - 1, 0);
            showCards(currentIndex);
        }

        // Event listener tombol navigasi
        nextBtn.addEventListener("click", nextCards);
        prevBtn.addEventListener("click", prevCards);

        // Event listener indikator
        indicators.forEach((indicator, i) => {
            indicator.addEventListener("click", () => {
                currentIndex = i;
                showCards(currentIndex);
            });
        });

        // Geser otomatis
        function startAutoSlide() {
            return setInterval(() => {
                if (currentIndex === Math.ceil(totalCards / cardsPerView) - 1) {
                    currentIndex = 0;
                } else {
                    currentIndex++;
                }
                showCards(currentIndex);
            }, 3000);
        }

        let autoSlideInterval = startAutoSlide();

        // Hentikan geser otomatis saat hover
        swiperContainer.addEventListener("mouseenter", () =>
            clearInterval(autoSlideInterval)
        );
        swiperContainer.addEventListener(
            "mouseleave",
            () => (autoSlideInterval = startAutoSlide())
        );

        // Menampilkan set kartu pertama
        showCards(currentIndex);
    </script>
</body>

</html>