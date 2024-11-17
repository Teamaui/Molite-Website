<!-- Main Content -->
<div class="main-content">
    <h1>Detail Jenis Edukasi</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>
        <form action="<?= UrlHelper::route("edukasi/detail-edukasi/store"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-left">
                    <input type="hidden" name="id_jenis_edukasi" value="<?= $idJenisEdukasi ?>">
                    <div>
                        <label for="judul_edukasi">Judul Edukasi</label>
                        <input type="text" id="judul_edukasi" placeholder="Masukkan Nama Imunisasi..." name="judul_edukasi" required>
                    </div>
                    <div class="deskripsi_edukasi">
                        <label for="deskripsi_edukasi">Deskripsi Edukasi</label>
                        <input id="deskripsi_edukasi" type="hidden" name="deskripsi_edukasi">
                        <trix-editor input="deskripsi_edukasi" placeholder="Masukkan Deskripsi Edukasi...."></trix-editor>
                    </div>
                </div>
                <div class="form-left">
                    <label for="img">Tambah Foto</label>
                    <div>
                        <input type="hidden" name="oldFoto" value="<?= $admin["img"] ?>">
                        <img class="img-card" id="photo-preview" src="<?= UrlHelper::img("edukasi/default.png") ?>" width="300" alt="">
                        <input type="file" id="file-input" class="file-input" name="foto" accept="image/*" onchange="displayFileName()">
                        <p class="img-p" id="file-name">Pilih foto untuk background edukasi</p>
                        <label for="file-input" class="custom-file-label">Pilih Foto</label>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>

    <div class="table-container left">
        <div class="table-button">
            <h1 class="">Daftar Edukasi : <?= $jenisEdukasi["nama_edukasi"] ?></h1>
            <form action="<?= UrlHelper::route("edukasi/detail-edukasi/" . $jenisEdukasi["id_jenis_edukasi"]) ?>" method="get">
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
                    <th>Judul Edukasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;

                foreach ($edukasi as $edk) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $edk["judul_edukasi"] ?></td>
                        <td>
                            <a class="view" href="<?= UrlHelper::route("edukasi/view/" . $edk["id_edukasi"]) ?>"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
                ?>
            </tbody>
        </table>
        <?php if (isset($_GET["search"])) : ?>
            <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('edukasi/detail-edukasi/' . $jenisEdukasi["id_jenis_edukasi"] . '?page='), $_GET["search"]) ?>
        <?php else : ?>
            <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('edukasi/detail-edukasi/' . $jenisEdukasi["id_jenis_edukasi"] . '?page=')) ?>
        <?php endif; ?>
    </div>
</div>