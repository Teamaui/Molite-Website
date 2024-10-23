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
                <p class="p1">Jl. Otto Iskandardinata No.82, Krajan, Ajung, Kec. Ajung, Kabupaten Jember, Jawa Timur 68175</p>
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

            <form action="<?= PathHelper::getPath() ?>/login" method="post">
                <div>
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" placeholder="Masukkan NIK..." name="nik" required>
                </div>
                <label for="sandi">Sandi</label>
                <div class="password-container">
                    <input type="password" id="sandi1" placeholder="Masukkan Sandi..." name="sandi" required>
                    <span class="toggle-password" id="toggle-password1"><i class="bi bi-eye-slash-fill"></i></span>
                </div>
                <button type="submit">Masuk</button>
            </form>
            <a href="<?= PathHelper::getPath() ?>/register">Belum punya akun? <span>Register</span></a>
        </div>
    </div>
</div>
<!-- End Body -->