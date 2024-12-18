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

            <form class="laporan" action="<?= UrlHelper::route("cetak-laporan") ?>" method="GET">
                <select name="rows" id="rows">
                    <option value="5" <?= (isset($_GET['rows']) && $_GET['rows'] == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= (isset($_GET['rows']) && $_GET['rows'] == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= (isset($_GET['rows']) && $_GET['rows'] == 20) ? 'selected' : '' ?>>20</option>
                    <option value="30" <?= (isset($_GET['rows']) && $_GET['rows'] == 30) ? 'selected' : '' ?>>30</option>
                </select>
                <input type="date" id="start_date" name="start_date" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
                <input type="date" id="end_date" name="end_date" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">

                <!-- Tombol submit -->
                <button type="submit">Tampilkan</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Berat Badan (KG)</th>
                    <th>Tinggi Badan (CM)</th>
                    <th>Lingkar Kepala (CM)</th>
                    <th>Tanggal Pencatatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pertumbuhan)) : ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Data tidak tersedia</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($pertumbuhan as $ptn) : ?>
                        <tr>
                            <td><?= $startNumber++ ?></td>
                            <td><?= $ptn["nama_anak"] ?></td>
                            <td><?= $ptn["berat_badan"] ?> kg</td>
                            <td><?= $ptn["tinggi_badan"] ?> cm</td>
                            <td><?= $ptn["lingkar_kepala"] ?> cm</td>
                            <td><?= $ptn["tanggal_pencatatan"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>
        <div class="btn-cetak-laporan">
            <a class="cetak" href="<?= UrlHelper::route("cetak-laporan/cetak?" . $_SERVER["QUERY_STRING"]) ?>">Cetak</a>
            <?php if (isset($_GET["start_date"]) && isset($_GET["end_date"])) : ?>
                <?= PaginationHelper::renderDate(
                    (isset($_GET["page"]) ? $_GET["page"] : 1),
                    $pagination["totalPages"],
                    UrlHelper::route('cetak-laporan?page='),
                    $_GET["start_date"],
                    $_GET["end_date"],
                    (isset($_GET["rows"]) ? $_GET["rows"] : 5)
                ) ?>
            <?php else : ?>
                <?= PaginationHelper::renderDate(
                    (isset($_GET["page"]) ? $_GET["page"] : 1),
                    $pagination["totalPages"],
                    UrlHelper::route('cetak-laporan?page='),
                    null,
                    null,
                    (isset($_GET["rows"]) ? $_GET["rows"] : 5)
                ) ?>
            <?php endif; ?>
        </div>
    </div>
</div>