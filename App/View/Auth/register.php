<!-- Start Body -->
<div class="main">
    <h1>Registrasi</h1>
    <p>Mohon lengkapi data dibawah ini!</p>

    <?php if (FlashMessageHelper::has("pesan_register_gagal")) : ?>
        <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_register_gagal"); ?></p>
    <?php endif; ?>

    <form class="form-register" action="<?= UrlHelper::route("register") ?>" method="post">
        <div class="main-form">
            <div class="form-left">
                <div>
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" placeholder="Masukkan NIK..." name="nik"  required>
                </div>
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Masukkan Username..." name="username" required>
                </div>
                <div>
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" placeholder="Masukkan Alamat Email..." name="email" required>
                </div>
            </div>
            <div class="form-right">
                <label for="sandi2">Sandi</label>
                <div class="password-container">
                    <input type="password" id="sandi2" placeholder="Masukkan Konfirmasi Sandi..." name="sandi1" required>
                    <span class="toggle-password" id="toggle-password2"><i class="bi bi-eye-slash-fill"></i></span>
                </div>
                <label for="sandi2">Konfirmasi Sandi</label>
                <div class="password-container">
                    <input type="password" id="sandi3" placeholder="Masukkan Konfirmasi Sandi..." name="sandi2" required>
                    <span class="toggle-password" id="toggle-password3"><i class="bi bi-eye-slash-fill"></i></span>
                </div>
            </div>
        </div>
        <button type="submit">Register</button>
    </form>
    <a href="<?= PathHelper::getPath() ?>/login">Sudah punya akun? <span>Masuk</span></a>
</div>
<!-- End Body -->