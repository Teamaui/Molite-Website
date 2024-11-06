<!-- Main Content -->
<div class="main-content">
    <h1>Edit Data Imunisasi</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("imunisasi/update"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <input type="hidden" name="id_jenis_imunisasi" value="<?= $imunisasi["id_jenis_imunisasi"] ?>">
                    <div>
                        <label for="nama_imunisasi">Nama Imunisasi</label>
                        <input type="text" id="nama_imunisasi" value="<?= $imunisasi["nama_imunisasi"] ?>" placeholder="Masukkan Nama Imunisasi..." name="nama_imunisasi" required>
                    </div>
                    <div>
                        <label for="deskripsi_imunisasi">Deskripsi Imunisasi</label>
                        <input type="text" id="deskripsi_imunisasi" value="<?= $imunisasi["deskripsi_imunisasi"] ?>" placeholder="Masukkan Deskripsi Imunisasi..." name="deskripsi_imunisasi" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>