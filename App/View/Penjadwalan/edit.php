<!-- Main Content -->
<div class="main-content">
    <h1>Edit Jadwal Imunisasi</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("penjadwalan/update"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <input type="hidden" name="id_jadwal_imunisasi" value="<?= $penjadwalan["id_jadwal_imunisasi"] ?>">
                    <div>
                        <label for="nama_anak">Nama Anak</label>
                        <select name="nama_anak" id="nama_anak">
                            <option value="null">---Pilih Anak---</option>
                            <?php foreach ($anak as $ank) : ?>
                                <?php if ($penjadwalan["id_anak"] == $ank["id_anak"]) : ?>
                                    <option value="<?= $ank["id_anak"] ?>" selected><?= $ank["nama_anak"] ?></option>
                                <?php else : ?>
                                    <option value="<?= $ank["id_anak"] ?>"><?= $ank["nama_anak"] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="nama_imunisasi">Jenis Imunisasi</label>
                        <select name="nama_imunisasi" id="nama_imunisasi">
                            <option value="null">---Pilih Imunisasi---</option>
                            <?php foreach ($imunisasi as $imn) : ?>
                                <?php if ($penjadwalan["id_jenis_imunisasi"] == $imn["id_jenis_imunisasi"]) : ?>
                                    <option value="<?= $imn["id_jenis_imunisasi"] ?>" selected><?= $imn["nama_imunisasi"] ?></option>
                                <?php else : ?>
                                    <option value="<?= $imn["id_jenis_imunisasi"] ?>"><?= $imn["nama_imunisasi"] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_imunisasi">Jadwal Imunisasi</label>
                        <input type="date" id="tanggal_imunisasi" value="<?= $penjadwalan["tanggal_imunisasi"] ?>" placeholder="Masukkan Jadwal Imunisasi..." name="tanggal_imunisasi" required>
                    </div>
                    <div>
                        <label for="usia_pemberian">Usia Pemberian</label>
                        <input type="number" step="any" min="0" id="usia_pemberian" value="<?= $penjadwalan["usia_pemberian"] ?>" placeholder="Masukkan Usia Pemberian..." name="usia_pemberian" required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="nama_bidan">Nama Bidan</label>
                        <input type="text" id="nama_bidan" value="<?= $penjadwalan["nama_bidan"] ?>" placeholder="Masukkan Nama Bidan..." name="nama_bidan" required>
                    </div>
                    <div>
                        <label for="tempat_imunisasi">Tempat Imunisasi</label>
                        <input type="text" id="tempat_imunisasi" value="<?= $penjadwalan["tempat_imunisasi"] ?>" placeholder="Masukkan Tempat Imunisasi..." name="tempat_imunisasi" required>
                    </div>
                    <div>
                        <label for="status_imunisasi">Status Imunisasi</label>
                        <select name="status_imunisasi" id="status_imunisasi">
                            <option value="Belum" <?= ($penjadwalan["status_imunisasi"] == "Belum") ? "selected" : "" ?>>Belum</option>
                            <option value="Tertunda" <?= ($penjadwalan["status_imunisasi"] == "Tertunda") ? "selected" : "" ?>>Tertunda</option>
                            <option value="Sudah" <?= ($penjadwalan["status_imunisasi"] == "Sudah") ? "selected" : "" ?>>Sudah</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>