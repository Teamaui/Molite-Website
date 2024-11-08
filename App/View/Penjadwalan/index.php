<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Penjadwalan Imunisasi</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="navbar">
            <nav>
                <a class="imunisasi active">
                    Imunisasi
                </a>
                <a href="<?= UrlHelper::route("penjadwalan/posyandu") ?>" class="posyandu">
                    Posyandu
                </a>
            </nav>
        </div>

        <div class="table-button">
            <a href="<?= UrlHelper::route("penjadwalan/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="<?= UrlHelper::route("/pertumbuhan") ?>" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <!-- username	password	email	nama_ibu	nama_ayah	NIK_ibu	NIK_ayah	alamat	no_telepon -->
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Jenis Imunisasi</th>
                    <th>Tanggal Pencatatan</th>
                    <th>Status Imunisasi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $status = null;
                foreach ($penjadwalan as $pjl) :
                    if ($pjl["status_imunisasi"] == "Sudah") {
                        $status = "success";
                    } else if ($pjl["status_imunisasi"] == "Tertunda") {
                        $status = "warning";
                    } else {
                        $status = "error";
                    }
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $pjl["nama_anak"] ?></td>
                        <td><?= $pjl["nama_imunisasi"] ?></td>
                        <td><?= $pjl["tanggal_imunisasi"] ?></td>
                        <td>
                            <div class="badge <?= $status ?>"><?= $pjl["status_imunisasi"] ?></div>
                        </td>
                        <td>
                            <a class="edit" href="<?= UrlHelper::route("penjadwalan/edit/" . $pjl["id_jadwal_imunisasi"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("penjadwalan/delete/" . $pjl["id_jadwal_imunisasi"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>