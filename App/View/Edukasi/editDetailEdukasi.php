<!-- Main Content -->
<div class="main-content">
    <h1>Edit Detail Jenis Edukasi</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <form action="<?= UrlHelper::route("edukasi/detail-edukasi/update"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-left">
                    <input type="hidden" name="id_jenis_edukasi" value="<?= $edukasi["id_jenis_edukasi"] ?>">
                    <input type="hidden" name="id_edukasi" value="<?= $edukasi["id_edukasi"] ?>">
                    <div>
                        <label for="judul_edukasi">Judul Edukasi</label>
                        <input type="text" id="judul_edukasi" value="<?= $edukasi["judul_edukasi"] ?>" placeholder="Masukkan Nama Imunisasi..." name="judul_edukasi" required>
                    </div>
                    <div class="deskripsi_edukasi">
                        <label for="deskripsi_edukasi">Deskripsi Edukasi</label>
                        <input id="deskripsi_edukasi" type="hidden" name="deskripsi_edukasi" value="<?= $edukasi["deskripsi_edukasi"] ?>">
                        <trix-editor input="deskripsi_edukasi" placeholder="Masukkan Deskripsi Edukasi...."></trix-editor>
                    </div>
                </div>
                <div class="form-left">
                    <label for="img">Tambah Foto</label>
                    <div>
                        <input type="hidden" name="oldFoto" value="<?= $edukasi["img"] ?>">
                        <img class="img-card" id="photo-preview" src="<?= UrlHelper::img("edukasi/" . $edukasi["img"]) ?>" width="300" alt="">
                        <input type="file" id="file-input" class="file-input" name="foto" accept="image/*" onchange="displayFileName()">
                        <p class="img-p" id="file-name">Pilih foto untuk background edukasi</p>
                        <label for="file-input" class="custom-file-label">Pilih Foto</label>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>