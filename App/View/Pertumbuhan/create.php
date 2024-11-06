<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Data Pertumbuhan</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("pertumbuhan/store"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <div>
                        <label for="nama_anak">Nama Anak</label>
                        <select name="nama_anak" id="nama_anak">
                            <option value="null">---Pilih Anak---</option>
                            <?php foreach ($anak as $ank) : ?>
                                <option value="<?= $ank["id_anak"] ?>"><?= $ank["nama_anak"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_catat">Tanggal Pencatatan</label>
                        <input type="date" id="tanggal_catat" placeholder="Masukkan Tanggal Lahir..." name="tanggal_catat" required>
                    </div>
                    <div>
                        <label for="berat_badan">Berat Badan</label>
                        <input type="number" step="any" min="0" id="berat_badan" placeholder="Masukkan Berat Badan (CM)..." name="berat_badan" required>
                    </div>
                </div>
                <div class="form-left">
                    <div>
                        <label for="tinggi_badan">Tinggi Badan</label>
                        <input type="number" step="any" min="0" id="tinggi_badan" placeholder="Masukkan Tinggi Badan (CM)..." name="tinggi_badan" required>
                    </div>
                    <div>
                        <label for="lingkar_kepala">Lingkar Kepala</label>
                        <input type="number" step="any" min="0" id="lingkar_kepala" placeholder="Masukkan Lebar Kepala (CM)..." name="lingkar_kepala" required>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>