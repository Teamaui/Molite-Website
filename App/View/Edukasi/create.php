<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Edukasi</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("edukasi/store"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <div>
                        <label for="nama_edukasi">Nama Edukasi</label>
                        <input type="text" id="nama_edukasi" placeholder="Masukkan Nama Edukasi..." name="nama_edukasi" required>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>