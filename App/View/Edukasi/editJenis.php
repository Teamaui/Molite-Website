<!-- Main Content -->
<div class="main-content">
    <h1>Edit Data Edukasi</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("edukasi/update-jenis"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <input type="hidden" name="id_jenis_edukasi" value="<?= $jenisEdukasi["id_jenis_edukasi"] ?>">
                    <div>
                        <label for="nama_edukasi">Nama Edukasi</label>
                        <input type="text" id="nama_edukasi" value="<?= $jenisEdukasi["nama_edukasi"] ?>" placeholder="Masukkan Nama Edukasi..." name="nama_edukasi" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>