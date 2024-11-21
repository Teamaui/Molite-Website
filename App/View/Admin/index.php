<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Admin</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <div class="table-button">
            <a href="<?= UrlHelper::route("admin/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="<?= UrlHelper::route("/admin") ?>" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <!-- id_admin	nik   nama_admin  email 	username	sandi  status_aktif -->
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($admin as $am) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $am["nik"] ?></td>
                        <td><?= $am["nama_admin"] ?></td>
                        <td>
                            <?php if ($am["username"]) : ?>
                                <?= $am["username"] ?>
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= $am["email"] ?></td>
                        <td>
                            <a class="view" id="viewAdmin" onclick="openModal()" href="#"><i class="bi bi-eye-fill"></i></a>
                            <a class="edit" href="<?= UrlHelper::route("admin/edit/" . $am["id_admin"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("admin/delete/" . $am["id_admin"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('admin?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('admin?page=')) ?>
        <?php endif; ?>
    </div>
</div>

<div class="modal" id="userModal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal()">X</button>
        <div class="modal-container">
            <h1>Detail Data Admin</h1>
            <div class="list-group">
                <div class="list-section">
                    <div class="list-item">
                        <img src="<?= UrlHelper::img("profile/default.png") ?>" alt="">
                    </div>
                    <div class="list-item">
                        <h3>Nama</h3>
                        <p>Tes</p>
                    </div>
                    <div class="list-item">
                        <h3>NIK</h3>
                        <p>Test</p>
                    </div>
                    <div class="list-item">
                        <h3>Email</h3>
                        <p>Test</p>
                    </div>
                    <div class="list-item">
                        <h3>Username</h3>
                        <p>Test</p>
                    </div>
                    <div class="list-item">
                        <h3>Status Aktivasi</h3>
                        <p>Test</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>