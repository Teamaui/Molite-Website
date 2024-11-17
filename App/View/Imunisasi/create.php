<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Imunisasi</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("imunisasi/store"); ?>" method="post">
            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>
            <div class="form-container">

                <div class="form-left">
                    <div>
                        <label for="nama_imunisasi">Nama Imunisasi</label>
                        <input type="text" id="jenis_imunisasi" placeholder="Masukkan Nama Imunisasi..." name="nama_imunisasi" required>
                    </div>
                    <div>
                        <label for="deskripsi_imunisasi">Deskripsi Imunisasi</label>
                        <input type="text" id="deskripsi_imunisasi" placeholder="Masukkan Deskripsi Imunisasi..." name="deskripsi_imunisasi" required>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>