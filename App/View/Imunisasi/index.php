<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Imunisasi</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <a href="<?= UrlHelper::route("imunisasi/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
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
                    <th>Jenis Imunisasi</th>
                    <th>Deskripsi Imunisasi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($jenisImunisasi as $js) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $js["nama_imunisasi"] ?></td>
                        <td><?= $js["deskripsi_imunisasi"]; ?></td>
                        <td>
                            <a class="edit" href="<?= UrlHelper::route("imunisasi/edit/" . $js["id_jenis_imunisasi"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="view" href="<?= UrlHelper::route("imunisasi/view/" . $js["id_jenis_imunisasi"]) ?>"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('imunisasi?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('imunisasi?page=')) ?>
        <?php endif; ?>
    </div>
</div>