<header class="topbar">
    <nav>
        <div class="left-nav">
            <div class="sub-left-nav">
                <div class="hamburger" onclick="toggleMenu()">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <a href=""><span class="mo">Mo</span><span class="lita">lita</span></a>
            </div>
            <ul class="nav-links">
                <li><a href="<?= UrlHelper::route("/#home") ?>" class="nav-link home">Home</a></li>
                <li><a href="<?= UrlHelper::route("/#layanan") ?>" class="nav-link about">Layanan</a></li>
                <li><a href="<?= UrlHelper::route("/#informasi") ?>" class="nav-link service">Informasi</a></li>
                <li><a href="<?= UrlHelper::route("/#edukasi") ?>" class="nav-link contact">Edukasi</a></li>
                <li><a href="<?= UrlHelper::route("/#data") ?>" class="nav-link contact">Data</a></li>
            </ul>
        </div>
        <div class="login-btn">
            <a href="<?= UrlHelper::route("login") ?>">Masuk / Daftar</a>
        </div>
    </nav>
</header>