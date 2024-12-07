<!-- Main Content -->
<div class="main-content">
    <h1>Edit Jadwal Posyandu</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("penjadwalan/posyandu/update"); ?>" method="post">
            <div class="form-container">

                <div class="form-left">
                    <input type="hidden" name="id_posyandu" value="<?= $posyandu["id_posyandu"] ?>">
                    <div>
                        <label for="nama_pos">Nama Pos</label>
                        <input type="text" id="nama_pos" value="<?= $posyandu["pos"] ?>" placeholder="Masukkan Nama Pos..." name="nama_pos" required>
                    </div>
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>