<!-- Start Body -->
<div class="main">
    <h2>Monitoring <span>Balita</span></h2>
    <div class="sub-main">
        <div class="sub-main-left">
            <div class="sub-main-img">
                <div class="sub-to-sub-main-img">
                    <img src="../img/logo.png" width="100" alt="Logo Molita">
                    <h3>Mo<span>lita</span></h3>
                    <p>Login sekarang untuk mulai memantau keamanan dan perkembangan <span class="txt1">Mo</span><span class="txt2">lita</span>.</p>
                </div>
                <p class="p1">Dibuat oleh Team Maui | Kelompok 2</p>
            </div>
        </div>
        <div class="sub-main-right">
            <h1>Lupa Sandi?</h1>
            <p>Mohon masukkan email untuk melanjutkan</p>

            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>

            <form action="<?= UrlHelper::route("lupa-sandi") ?>" method="post">
                <div>
                    <label for="email">Alamat Email</label>
                    <input type="text" id="email" placeholder="Masukkan Alamat Email..." name="email" required>
                </div>

                <button type="submit">Ganti Sandi</button>
            </form>
            <a href="<?= UrlHelper::route("/login") ?>">Kembali ke halaman masuk? <span>Masuk</span></a>
        </div>
    </div>
</div>
<!-- End Body -->