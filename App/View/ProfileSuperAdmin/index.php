<!-- Main Content -->
<div class="main-content">
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <h1>Edit Profile</h1>
        <form action="<?= UrlHelper::route("edit-profile/update") ?>" method="post" enctype="multipart/form-data">
            <div class="header-img">
                <div class="img-left">
                    <input type="hidden" name="oldFoto" value="<?= $superAdmin["img"] ?>">
                    <img id="photo-preview" src="<?= UrlHelper::img("profile/" . $superAdmin["img"]) ?>" width="200" alt="">
                </div>
                <div class="img-right">
                    <input type="file" id="file-input" class="file-input" name="foto" accept="image/*" onchange="displayFileName()">
                    <label for="file-input" class="custom-file-label">Pilih Foto</label>
                    <p id="file-name">Pilih file untuk ganti foto profile</p>
                </div>
            </div>
            <div class="main-img">
                <h1>INFORMASI AKUN</h1>
                <div>
                    <label for="email">Alamat Email</label>
                    <input type="text" id="email" placeholder="Masukkan Alamat Email..." value="<?= $superAdmin["email"] ?>" name="email" required>
                </div>
                <div>
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" placeholder="Masukkan Nama Lengkap..." value="<?= $superAdmin["nama"] ?>" name="nama" required>
                </div>
                <div>
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" placeholder="Masukkan Alamat..." value="<?= $superAdmin["alamat"] ?>" name="alamat" required>
                </div>

                <h1>KEAMANAN AKUN</h1>
                <div>
                    <div class="password-container">
                        <label for="sandi1">Sandi Sekarang</label>
                        <input type="password" id="sandi1" placeholder="Masukkan Sandi Sekarang..." name="password_sekarang">
                        <span class="toggle-password" id="toggle-password1"><i class="bi bi-eye-slash-fill"></i></span>
                    </div>
                </div>
                <div>
                    <div class="password-container">
                        <label for="sandi2">Ganti Sandi</label>
                        <input type="password" id="sandi2" placeholder="Masukkan Sandi Baru..." name="new_password">
                        <span class="toggle-password" id="toggle-password2"><i class="bi bi-eye-slash-fill"></i></span>
                    </div>
                </div>
                <div>
                    <div class="password-container">
                        <label for="sandi3">Konfirmasi Sandi</label>
                        <input type="password" id="sandi3" placeholder="Masukkan Konfirmasi Sandi..." name="repeat_password">
                        <span class="toggle-password" id="toggle-password3"><i class="bi bi-eye-slash-fill"></i></span>
                    </div>
                </div>

                <button class="submit">Edit Profile</button>
            </div>
        </form>
    </div>
</div>