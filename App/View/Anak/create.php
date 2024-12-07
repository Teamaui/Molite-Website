<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Anak</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("anak/store"); ?>" method="post">
            <div class="form-container">
                <div class="form-left">
                    <div>
                        <label for="nama_anak">Nama Lengkap Anak</label>
                        <input type="text" id="nama_anak" placeholder="Masukkan Nama Anak..." name="nama_anak" required>
                    </div>
                    <div>
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" placeholder="Masukkan Tanggal Lahir..." name="tanggal_lahir" required>
                    </div>
                    <div>
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" placeholder="Masukkan Tempat Lahir..." name="tempat_lahir" required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="id_orang_tua">Orang Tua</label>
                        <select name="id_orang_tua" id="id_orang_tua">
                            <option value="null">---Pilih Orang Tua---</option>
                            <?php foreach ($orangTua as $ot) : ?>
                                <option value="<?= $ot["id_orang_tua"] ?>"><?= $ot["nama_ayah"] ?> & <?= $ot["nama_ibu"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>