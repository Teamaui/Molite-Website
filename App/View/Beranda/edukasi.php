<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div class="main-content">
        <div class="edukasi-content">
            <h1><?= $edukasi["judul_edukasi"] ?></h1>

            <div class="edukasi-img">
                <img src="<?= UrlHelper::img('edukasi/' . $edukasi["img"]) ?>" alt="Edukasi Image">
            </div>
            <div class="main-teks">
                <p><?= $edukasi["deskripsi_edukasi"] ?></p>
            </div>
            <div class="edukasi-aksi">
                <a href="<?= UrlHelper::route("/") ?>" onclick="setActive()" class="back"><i class="bi bi-backspace"></i> Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>