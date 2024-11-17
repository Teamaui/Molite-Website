<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Edukasi</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <a href="<?= UrlHelper::route("edukasi/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="<?= UrlHelper::route("edukasi") ?>" method="get">
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
                    <th>Jenis Edukasi</th>
                    <th>Jumlah Edukasi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($edukasi as $edk) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $edk["nama_edukasi"] ?></td>
                        <td><?= $edk["jumlah_edukasi"] ?></td>
                        <td>
                            <a class="view" href="<?= UrlHelper::route("edukasi/detail-edukasi/" . $edk["id_jenis_edukasi"]) ?>"><i class="bi bi-eye-fill"></i></a>
                            <a class="edit" href="<?= UrlHelper::route("edukasi/edit-jenis/" . $edk["id_jenis_edukasi"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('edukasi?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('edukasi?page=')) ?>
        <?php endif; ?>
    </div>
</div>