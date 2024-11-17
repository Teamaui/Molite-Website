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
            <h1>Ganti sandi</h1>
            <p>Mohon masukkan email untuk melanjutkan</p>

            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>

            <form action="<?= UrlHelper::route("ganti-sandi") ?>" method="post">
                <input type="hidden" name="id_admin" value="<?= $idAdmin ?>">
                <label for="gantiSandi1">Kata sandi baru</label>
                <div class="password-container">
                    <input type="password" id="gantiSandi1" placeholder="Masukkan Konfirmasi Sandi..." name="sandi1" required>
                    <span class="toggle-password" id="toggle-ganti-password1"><i class="bi bi-eye-slash-fill"></i></span>
                </div>
                <label for="gantiSandi2">Konfirmasi kata sandi baru</label>
                <div class="password-container">
                    <input type="password" id="gantiSandi2" placeholder="Masukkan Konfirmasi Sandi..." name="sandi2" required>
                    <span class="toggle-password" id="toggle-ganti-password2"><i class="bi bi-eye-slash-fill"></i></span>
                </div>

                <button type="submit">Ganti Sandi</button>
            </form>
            <a href="<?= PathHelper::getPath() ?>/login">Kembali ke halaman masuk? <span>Masuk</span></a>
        </div>
    </div>
</div>
<!-- End Body -->