<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Orang Tua</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <div class=""></div>
            <form action="<?= UrlHelper::route("/orang-tua-admin") ?>" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                    <th>Nama Ibu</th>
                    <th>Nama Ayah</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $status = null;

                foreach ($orangTua as $ot) :

                    if ($ot["status_aktivasi"] == "Aktif") {
                        $status = "success";
                    } else {
                        $status = "error";
                    } ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $ot["email"] ?></td>
                        <td><?= $ot["nama_ibu"] ?></td>
                        <td><?= $ot["nama_ayah"] ?></td>
                        <td><?= $ot["alamat"] ?></td>
                        <td>
                            <a class="view" href="<?= UrlHelper::route("orang-tua-admin/view/" . $ot["status_aktivasi"]) ?>"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('orang-tua-admin?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('orang-tua-admin?page=')) ?>
        <?php endif; ?>
    </div>
</div>