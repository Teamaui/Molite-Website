<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Penjadwalan Posyandu</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="navbar">
            <nav>
                <a href="<?= UrlHelper::route("penjadwalan") ?>" class="imunisasi">
                    Imunisasi
                </a>
                <a class="posyandu active">
                    Posyandu
                </a>
            </nav>
        </div>

        <div class="table-button">
            <a href="<?= UrlHelper::route("penjadwalan/posyandu/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="<?= UrlHelper::route("penjadwalan/posyandu") ?>" method="get">
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
                    <th>Pos</th>
                    <th>Tanggal Posyandu</th>
                    <th>Jam Posyandu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $status = null;
                foreach ($penjadwalan as $pjl) : ?>
                    <tr>
                        <td><?= $startNumber++ ?></td>
                        <td><?= $pjl["pos"] ?></td>
                        <td><?= $pjl["tanggal"] ?></td>
                        <td><?= $pjl["jam"] ?></td>
                        <td>
                            <a class="edit" href="<?= UrlHelper::route("penjadwalan/posyandu/edit/" . $pjl["id_jadwal_posyandu"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("penjadwalan/posyandu/delete/" . $pjl["id_jadwal_posyandu"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('penjadwalan/posyandu?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('penjadwalan/posyandu?page=')) ?>
        <?php endif; ?>
    </div>
</div>