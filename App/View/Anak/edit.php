<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Anak</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("anak/update"); ?>" method="post">
            <div class="form-container">
                <div class="form-left">
                    <input type="hidden" name="id_anak" value="<?= $anak["id_anak"] ?>">
                    <div>
                        <label for="nama_anak">Nama Lengkap Anak</label>
                        <input type="text" id="nama_anak" placeholder="Masukkan Nama Anak..." value="<?= $anak["nama_anak"] ?>" name="nama_anak" required>
                    </div>
                    <div>
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" placeholder="Masukkan Tanggal Lahir..." value="<?= $anak["tanggal_lahir"] ?>" name="tanggal_lahir" required>
                    </div>
                    <div>
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" placeholder="Masukkan Tempat Lahir..." value="<?= $anak["tempat_lahir"] ?>" name="tempat_lahir" required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin">
                            <option value="Laki-Laki" <?= ($anak["jenis_kelamin"] == "Perempuan") ? "" : "selected" ?>>Laki-Laki</option>
                            <option value="Perempuan" <?= ($anak["jenis_kelamin"] == "Perempuan") ? "selected" : "" ?>>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="id_orang_tua">Orang Tua</label>
                        <select name="id_orang_tua" id="id_orang_tua">
                            <option value="null">---Pilih Orang Tua---</option>
                            <?php foreach ($orangTua as $ot) : ?>
                                <?php if ($anak["id_orang_tua"] == $ot["id_orang_tua"]) : ?>
                                    <option value="<?= $ot["id_orang_tua"] ?>" selected><?= $ot["nama_ibu"] ?></option>
                                <?php else : ?>
                                    <option value="<?= $ot["id_orang_tua"] ?>"><?= $ot["nama_ibu"] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>