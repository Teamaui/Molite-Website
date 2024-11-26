<!-- Main Content -->
<div class="main-content">
    <h1>Cetak Laporan</h1>
    <div class="table-container">
        <?php

        use App\Helper\PaginationHelper;
        use App\Helper\ViewReader;

        if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <form action="<?= UrlHelper::route("cetak-laporan") ?>" method="GET">
                <div class="laporan">
                    <input type="date" id="start_date" name="start_date" required>
                    <input type="date" id="end_date" name="end_date" required>

                    <button type="submit">Tampilkan</button>
                </div>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Berat Badan (Gram)</th>
                    <th>Tinggi Badan (CM)</th>
                    <th>Lingkar Kepala (CM)</th>
                    <th>Tanggal Pencatatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($pertumbuhan as $ptn) : ?>
                    <tr>
                        <td><?= $startNumber++ ?></td>
                        <td><?= $ptn["nama_anak"] ?></td>
                        <td><?= $ptn["berat_badan"] ?> gram</td>
                        <td><?= $ptn["tinggi_badan"] ?> cm</td>
                        <td><?= $ptn["lingkar_kepala"] ?> cm</td>
                        <td><?= $ptn["tanggal_pencatatan"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <?php if (isset($_GET["start_date"]) && isset($_GET["end_date"])) : ?>
            <?= PaginationHelper::renderDate((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('cetak-laporan?page='), $_GET["start_date"], $_GET["end_date"]) ?>
        <?php else : ?>
            <?= PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('cetak-laporan?page=')) ?>
        <?php endif; ?>

        <div class="btn-cetak-laporan">
            <a href="<?= UrlHelper::route("cetak-laporan/cetak?" . $_SERVER["QUERY_STRING"]) ?>">Cetak</a>
        </div>
    </div>
</div>