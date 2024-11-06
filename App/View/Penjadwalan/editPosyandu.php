<!-- Main Content -->
<div class="main-content">
    <h1>Edit Jadwal Posyandu</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("penjadwalan/posyandu/update"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <input type="hidden" name="id_jadwal_posyandu" value="<?= $posyandu["id_jadwal_posyandu"] ?>">
                    <div>
                        <label for="nama_pos">Nama Pos</label>
                        <input type="text" id="nama_pos" value="<?= $posyandu["pos"] ?>" placeholder="Masukkan Nama Pos..." name="nama_pos" required>
                    </div>
                    <div>
                        <label for="tanggal">Jadwal Posyandu</label>
                        <input type="date" id="tanggal" value="<?= $posyandu["tanggal"] ?>" placeholder="Masukkan Tanggal Posyandu..." name="tanggal" required>
                    </div>
                    <div>
                        <label for="jam">Jam Posyandu</label>
                        <input type="time" id="jam" value="<?= $posyandu["jam"] ?>" placeholder="Masukkan Jam Posyandu..." name="jam" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>