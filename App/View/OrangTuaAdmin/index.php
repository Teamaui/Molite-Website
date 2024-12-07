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
                <?php if (empty($orangTua)) : ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Data tidak tersedia</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($orangTua as $ot) :
                        if ($ot["status_aktivasi"] == "Aktif") {
                            $status = "success";
                        } else {
                            $status = "error";
                        } ?>
                        <tr>
                            <td><?= $startNumber++ ?></td>
                            <td><?= $ot["email"] ?></td>
                            <td><?= $ot["nama_ibu"] ?></td>
                            <td><?= $ot["nama_ayah"] ?></td>
                            <td><?= $ot["alamat"] ?></td>
                            <td>
                                <a class="view" id="viewAdmin" data-id="<?= $ot["id_orang_tua"] ?>" onclick="showDetailOrangtua(this)" href="#"><i class="bi bi-eye-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('orang-tua-admin?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('orang-tua-admin?page=')) ?>
        <?php endif; ?>
    </div>
</div>
<div class="modal" id="userModalOrangTua">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModalOrangTua()">X</button>
        <div class="modal-container">
            <h1>Detail Data Orang Tua</h1>
            <div class="list-group">
                <div class="list-section">
                    <div class="list-item">
                        <h3>Alamat Email</h3>
                        <p id="email-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>NIK Ibu</h3>
                        <p id="nik-ibu-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>NIK Ayah</h3>
                        <p id="nik-ayah-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>Nama Ibu</h3>
                        <p id="nama-ibu-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>Nama Ayah</h3>
                        <p id="nama-ayah-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>Nomor Telepon</h3>
                        <p id="nomor-telepon-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>Alamat</h3>
                        <p id="alamat-admin-orang-tua"></p>
                    </div>
                    <div class="list-item">
                        <h3>Status Aktivasi</h3>
                        <p class="badge" id="status-aktivasi-admin-orang-tua"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>