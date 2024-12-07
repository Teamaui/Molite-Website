<!-- Main Content -->
<div class="main-content">
    <h1>Edit Jadwal Posyandu</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <!-- Tabs untuk tambah data -->
        <form action="<?= UrlHelper::route("penjadwalan/posyandu/view/update"); ?>" method="post">
            <div class="form-container">
                <div class="form-left">
                    <input type="hidden" name="id_posyandu" value="<?= $jadwalPosyandu["id_posyandu"] ?>">
                    <input type="hidden" name="id_jadwal_posyandu" value="<?= $jadwalPosyandu["id_jadwal_posyandu"] ?>">
                    <div>
                        <label for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" value="<?= $jadwalPosyandu["tanggal"] ?>" placeholder="Masukkan Nama Imunisasi..." name="tanggal" required>
                    </div>
                    <div>
                        <label for="jam_mulai">Jam Posyandu</label>
                        <div class="jam">
                            <input type="time" id="jam_mulai" value="<?= $jadwalPosyandu["jam_mulai"] ?>" name="jam_mulai" required>
                            <div class="garis"> - </div>
                            <input type="time" id="jam_selesai" value="<?= $jadwalPosyandu["jam_selesai"] ?>" name="jam_selesai" required>
                        </div>
                        <small id="error-message" style="color: red; display: none;">Jam mulai tidak boleh lebih besar dari jam selesai.</small>
                    </div>
                </div>
            </div>
            <button type="submit" id="btn-jam">Edit Data</button>
        </form>
    </div>
</div>