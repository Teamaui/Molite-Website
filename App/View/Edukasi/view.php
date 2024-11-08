<!-- Main Content -->
<div class="main-content">
    <div class="edukasi-content">
        <h1><?= $edukasi["judul_edukasi"] ?></h1>
        <div class="edukasi-aksi">
            <a href="<?= UrlHelper::route("edukasi/detail-edukasi/" . $edukasi["id_jenis_edukasi"]) ?>" onclick="setActive()" class="back"><i class="bi bi-backspace"></i> Kembali</a>
            <a class="edit" href="<?= UrlHelper::route("edukasi/edit-detail-edukasi/" . $edukasi["id_edukasi"]) ?>"><i class="bi bi-pencil-fill"></i></a>
            <a class="hapus" href="<?= UrlHelper::route("edukasi/delete-detail-edukasi/" . $edukasi["id_edukasi"]) ?>"><i class="bi bi-trash"></i></a>
        </div>
        <img src="<?= UrlHelper::img('edukasi/' . $edukasi["img"]) ?>" alt="">
        <div class="main-teks">
            <?= $edukasi["deskripsi_edukasi"] ?>
        </div>
    </div>

</div>