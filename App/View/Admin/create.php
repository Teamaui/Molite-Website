<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Admin</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("admin/store") ?>" method="post">
            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>
            <div class="form-container">
                <div class="form-left">
                    <div>
                        <label for="nik">NIK</label>
                        <input type="text" id="nik" placeholder="Masukkan NIK..." name="nik" required>
                    </div>
                    <div>
                        <label for="nama_admin">Nama Admin</label>
                        <input type="text" id="nama_admin" placeholder="Masukkan Nama Admin..." name="nama_admin" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="text" id="email" placeholder="Masukkan Email..." name="email" required>
                    </div>
                </div>
                <div class="form-left">
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>