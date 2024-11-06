<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Imunisasi : <?= $jenisImunisasi["nama_imunisasi"] ?></h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <div><a href="<?= UrlHelper::route("imunisasi") ?>" onclick="setActive()"><i class="bi bi-backspace"></i> Kembali</a></div>
            <form action="" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Jadwal Pencatatan</th>
                    <th>Status Imunisasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $status = null;
                foreach ($imunisasi as $imn) :
                    if ($imn["status_imunisasi"] == "Sudah") {
                        $status = "success";
                    } else if ($imn["status_imunisasi"] == "Tertunda") {
                        $status = "warning";
                    } else {
                        $status = "error";
                    }
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $imn["nama_anak"] ?></td>
                        <td><?= $imn["tanggal_imunisasi"] ?></td>
                        <td>
                            <div class="badge <?= $status ?>"><?= $imn["status_imunisasi"] ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>