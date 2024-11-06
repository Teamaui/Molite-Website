<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Pertumubuhan Anak</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <a href="<?= UrlHelper::route("pertumbuhan/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
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
                    <th>Berat Badan</th>
                    <th>Tinggi Badan</th>
                    <th>Lingkar Kepala</th>
                    <th>Tanggal Pencatatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($pertumbuhan as $ptn) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $ptn["nama_anak"] ?></td>
                        <td><?= $ptn["berat_badan"] ?> gram</td>
                        <td><?= $ptn["tinggi_badan"] ?> cm</td>
                        <td><?= $ptn["lingkar_kepala"] ?> cm</td>
                        <td><?= $ptn["tanggal_pencatatan"] ?></td>
                        <td>
                            <a class="edit" href="<?= UrlHelper::route("pertumbuhan/edit/" . $ptn["id_pertumbuhan"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("pertumbuhan/delete/" . $ptn["id_pertumbuhan"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>