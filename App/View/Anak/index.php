<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Anak</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <a href="<?= UrlHelper::route("anak/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <!-- ID_anak	nama_anak	tanggal_lahir	tempat_lahir	jenis_kelamin	ID_orang_tua -->
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Tempat Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Orang Tua</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($anak)) : ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Data tidak tersedia</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($anak as $a) : ?>
                        <tr>
                            <td><?= $startNumber++; ?></td>
                            <td><?= $a["nama_anak"] ?></td>
                            <td><?= $a["tanggal_lahir"] ?></td>
                            <td><?= $a["tempat_lahir"] ?></td>
                            <td><?= $a["jenis_kelamin"] ?></td>
                            <td>
                                <?= isset($a["nama_ibu"]) ? $a["nama_ayah"] . " & " . $a["nama_ibu"] : "-" ?>
                            </td>
                            <td>
                                <a class="view" href="<?= UrlHelper::route("anak/view/" . $a["id_anak"]) ?>"><i class="bi bi-eye-fill"></i></a>
                                <a class="edit" href="<?= UrlHelper::route("anak/edit/" . $a["id_anak"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                                <a class="hapus" href="<?= UrlHelper::route("anak/delete/" . $a["id_anak"]) ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('anak?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('anak?page=')) ?>
        <?php endif; ?>
    </div>
</div>