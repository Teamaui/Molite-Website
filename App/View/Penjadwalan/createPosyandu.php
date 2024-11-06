<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Jadwal Posyandu</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("penjadwalan/posyandu/store"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <div>
                        <label for="nama_pos">Nama Pos</label>
                        <input type="text" id="nama_pos" placeholder="Masukkan Nama Pos..." name="nama_pos" required>
                    </div>
                    <div>
                        <label for="tanggal">Jadwal Posyandu</label>
                        <input type="date" id="tanggal" placeholder="Masukkan Tanggal Posyandu..." name="tanggal" required>
                    </div>
                    <div>
                        <label for="jam">Jam Posyandu</label>
                        <input type="time" id="jam" placeholder="Masukkan Jam Posyandu..." name="jam" required>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>