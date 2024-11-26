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
                <!-- <p class="p1">Dibuat oleh Team Maui | Kelompok 2</p> -->
            </div>
        </div>
        <div class="sub-main-right">
            <h1>Masuk</h1>
            <p>Mohon masuk untuk melanjutkan</p>

            <?php if (FlashMessageHelper::has("pesan_register_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_register_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_login_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_login_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_login_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_login_gagal"); ?></p>
            <?php endif; ?>

            <form action="<?= UrlHelper::route("login") ?>" method="post">
                <div>
                    <label for="nik_atau_email">NIK / Email</label>
                    <input type="text" id="nik_atau_email" placeholder="Masukkan NIK atau Email..." name="nik_atau_email" required>
                </div>
                <div class="label-sandi">
                    <label for="sandi">Sandi</label>
                    <a href="<?= UrlHelper::route("lupa-sandi") ?>">Lupa Sandi?</a>
                </div>
                <div class="password-container">
                    <input type="password" id="sandi1" placeholder="Masukkan Sandi..." name="sandi" required>
                    <span class="toggle-password" id="toggle-password1"><i class="bi bi-eye-slash-fill"></i></span>
                </div>
                <button type="submit">Masuk</button>
            </form>
            <div class="a-pack">
                <a class="a-daftar" href="<?= PathHelper::getPath() ?>/register">Belum punya akun? <span>Register</span></a>
                <a class="a-back" href="<?= PathHelper::getPath() ?>">Kembali</a>
            </div>
        </div>
    </div>
</div>
<!-- End Body -->