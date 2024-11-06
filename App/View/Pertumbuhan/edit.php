<!-- Main Content -->
<div class="main-content">
    <h1>Edit Data Pertumbuhan</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("pertumbuhan/update"); ?>" method="post">
            <div class="form-container">


                <div class="form-left">
                    <input type="hidden" name="id_pertumbuhan" value="<?= $pertumbuhan["id_pertumbuhan"] ?>">
                    <div>
                        <label for="nama_anak">Nama Anak</label>
                        <select name="nama_anak" id="nama_anak">
                            <option value="null">---Pilih Anak---</option>
                            <?php foreach ($anak as $ank) : ?>
                                <?php if ($ank["id_anak"] == $pertumbuhan["id_anak"]) : ?>
                                    <option value="<?= $ank["id_anak"] ?>" selected><?= $ank["nama_anak"] ?></option>
                                <?php else : ?>
                                    <option value="<?= $ank["id_anak"] ?>"><?= $ank["nama_anak"] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_catat">Tanggal Pencatatan</label>
                        <input type="date" id="tanggal_catat" value="<?= $pertumbuhan["tanggal_pencatatan"] ?>" placeholder="Masukkan Tanggal Lahir..." name="tanggal_catat" required>
                    </div>
                    <div>
                        <label for="berat_badan">Berat Badan</label>
                        <input type="number" step="any" min="0" id="berat_badan" value="<?= $pertumbuhan["berat_badan"] ?>" placeholder="Masukkan Berat Badan (CM)..." name="berat_badan" required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="tinggi_badan">Tinggi Badan</label>
                        <input type="number" step="any" min="0" id="tinggi_badan" value="<?= $pertumbuhan["tinggi_badan"] ?>" placeholder="Masukkan Tinggi Badan (CM)..." name="tinggi_badan" required>
                    </div>
                    <div>
                        <label for="lingkar_kepala">Lingkar Kepala</label>
                        <input type="number" step="any" min="0" id="lingkar_kepala" value="<?= $pertumbuhan["lingkar_kepala"] ?>" placeholder="Masukkan Lebar Kepala (CM)..." name="lingkar_kepala" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>