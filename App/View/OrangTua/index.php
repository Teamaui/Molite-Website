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
            <a href="<?= UrlHelper::route("orang-tua/create"); ?>"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="<?= UrlHelper::route("/orang-tua") ?>" method="get">
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
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($orangTua as $ot) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $ot["email"] ?></td>
                        <td><?= $ot["nama_ibu"] ?></td>
                        <td><?= $ot["nama_ayah"] ?></td>
                        <td><?= $ot["alamat"] ?></td>
                        <td><?= $ot["no_telepon"] ?></td>
                        <td>
                            <a class="view" href="<?= UrlHelper::route("orang-tua/view/" . $ot["id_orang_tua"]) ?>"><i class="bi bi-eye-fill"></i></a>
                            <a class="edit" href="<?= UrlHelper::route("orang-tua/edit/" . $ot["id_orang_tua"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="hapus" href="<?= UrlHelper::route("orang-tua/delete/" . $ot["id_orang_tua"]) ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>