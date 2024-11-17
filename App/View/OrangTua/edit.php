<!-- Main Content -->
<div class="main-content">
    <h1>Edit Data Orang Tua</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("orang-tua/update") ?>" method="post">
            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>
            <div class="form-container">

                <!-- ID_orang_tua	username	password	email	nama_ibu	nama_ayah	NIK_ibu	NIK_ayah	alamat	no_telepo -->
                <div class="form-left">
                    <input type="hidden" id="id_orang_tua" name="id_orang_tua" value="<?= $orangTua["id_orang_tua"] ?>">
                    <div>
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" placeholder="Masukkan Email..." name="email" value="<?= $orangTua["email"] ?>" required>
                    </div>
                    <div>
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" id="nama_ibu" placeholder="Masukkan Nama Ibu..." name="nama_ibu" value="<?= $orangTua["nama_ibu"] ?>" required>
                    </div>
                    <div>
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" id="nama_ayah" placeholder="Masukkan Nama Ayah..." name="nama_ayah" value="<?= $orangTua["nama_ayah"] ?>" required>
                    </div>
                    <div>
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" placeholder="Masukkan Alamat..." name="alamat" value=<?= $orangTua["alamat"] ?> required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="nik_ibu">NIK Ibu</label>
                        <input type="text" id="nik_ibu" placeholder="Masukkan NIK Ibu..." name="nik_ibu" value=<?= $orangTua["nik_ibu"] ?> required>
                    </div>
                    <div>
                        <label for="nik_ayah">NIK Ayah</label>
                        <input type="text" id="nik_ayah" placeholder="Masukkan NIK Ayah..." name="nik_ayah" value=<?= $orangTua["nik_ayah"] ?> required>
                    </div>
                    <div>
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" id="nomor_telepon" placeholder="Masukkan Nomor Telepon..." name="nomor_telepon" value="<?= $orangTua["no_telepon"] ?>" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>