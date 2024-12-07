<!-- Main Content -->
<div class="main-content">
    <div class="main-content-view">
        <div class="container-top">
            <h1>Detail Orang Tua</h1>
            <div class="list-group">
                <div class="list-section">
                    <div class="list-item">
                        <h3>Alamat Email</h3>
                        <p><?= $orangTua[0]["email"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>NIK Ayah</h3>
                        <p><?= $orangTua[0]["nik_ayah"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>NIK Ibu</h3>
                        <p><?= $orangTua[0]["nik_ayah"] ?></p>
                    </div>
                </div>
                <div class="list-section">
                    <div class="list-item">
                        <h3>Nama Ibu</h3>
                        <p><?= $orangTua[0]["nik_ayah"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>Nama Ayah</h3>
                        <p><?= $orangTua[0]["nik_ayah"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>Nomor Telepon</h3>
                        <p><?= $orangTua[0]["no_telepon"] ?></p>
                    </div>
                </div>
                <div class="list-section">
                    <div class="list-item">
                        <h3>Alamat</h3>
                        <p><?= $orangTua[0]["alamat"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>Posyandu</h3>
                        <p><?= $orangTua[0]["pos"] ?></p>
                    </div>
                    <div class="list-item">
                        <h3>Status Aktivasi</h3>
                        <p>
                            <?php
                            $status = null;

                            if ($orangTua[0]["status_aktivasi"] == "Aktif") {
                                $status = "success";
                            } else {
                                $status = "error";
                            }
                            ?>
                        <div class="badge <?= $status ?>"><?= $orangTua[0]["status_aktivasi"] ?></div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-bottom">
            <?php foreach ($orangTua as $ot) : ?>
                <?php if (!is_null($ot["nama_anak"])) : ?>
                    <div class="card">
                        <h3><?= $ot["nama_anak"] ?></h3>
                        <div class="list-item">
                            <h4>Tanggal Lahir</h4>
                            <p><?= $ot["tanggal_lahir"] ?></p>
                        </div>
                        <div class="list-item">
                            <h4>Tempat Lahir</h4>
                            <p><?= $ot["tempat_lahir"] ?></p>
                        </div>
                        <div class="list-item">
                            <h4>Jenis Kelamin</h4>
                            <p>
                                <?php
                                $status = null;

                                if ($ot["jenis_kelamin"] == "Perempuan") {
                                    $status = "pink";
                                } else {
                                    $status = "blue";
                                }
                                ?>
                            <div class="badge <?= $status ?>"><?= $ot["jenis_kelamin"] ?></div>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="card card-end">
                <a href="<?= UrlHelper::route("anak/create") ?>">
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>
</div>