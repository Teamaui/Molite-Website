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

<body>
    <header class="topbar" id="header">
        <nav>
            <div class="logo">
                <a href=""><img src="<?= UrlHelper::img("logo.png"); ?>" width="27" alt=""><span class="mo">Mo</span><span class="lita">lita</span></a>
            </div>
            <div class="">
                <ul class="nav-links">
                    <li><a href="#" class="nav-link home" data-page="home">Home</a></li>
                    <li><a href="#" class="nav-link about" data-page="about">About</a></li>
                    <li><a href="#" class="nav-link service" data-page="service">Services</a></li>
                    <li><a href="#" class="nav-link contact" data-page="contact">Contact</a></li>
                </ul>
            </div>
            <div class="login-btn">
                <a href="<?= UrlHelper::route("login") ?>"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
            </div>
        </nav>
    </header>
    <main>
        <img src="<?= UrlHelper::img("assets/background.png") ?>" alt="" class="top">
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
        <img src="<?= UrlHelper::img("assets/background.png") ?>" alt="" class="bottom">
    </main>

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

        document.addEventListener("DOMContentLoaded", () => {
            const links = document.querySelectorAll(".nav-link");
            const pages = document.querySelectorAll(".nav-link");

            document.querySelector(".home").classList.add("active-link");

            links.forEach(link => {
                link.addEventListener("click", (e) => {

                    pages.forEach(e => {
                        e.classList.remove("active-link");
                    });

                    e.preventDefault();

                    // Dapatkan halaman yang ingin ditampilkan
                    const page = link.getAttribute("data-page");

                    // Tampilkan halaman yang sesuai dengan menambahkan kelas 'active'
                    document.querySelector(`.${page}`).classList.add("active-link");
                });
            });
        });
    </script>
</body>

</html>