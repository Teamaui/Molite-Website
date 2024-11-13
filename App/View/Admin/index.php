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
            <form action="<?= UrlHelper::route("/edit") ?>" method="get">
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
                            <a class="view" href="<?= UrlHelper::route("admin/view/" . $am["id_admin"]) ?>"><i class="bi bi-eye-fill"></i></a>
                            <a class="edit" href="<?= UrlHelper::route("admin/edit/" . $am["id_admin"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("admin/delete/" . $am["id_admin"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>