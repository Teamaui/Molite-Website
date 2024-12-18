<!-- Main Content -->
<div class="main-content">
    <div class="main-content-view">
        <div class="container-left">
            <h1>Data Anak</h1>
            <div class="list-group">
                <div class="list-item">
                    <h3>Nama Anak</h3>
                    <p id="idAnak" data-id="<?= $anak["id_anak"] ?>"><?= $anak["nama_anak"] ?></p>
                </div>
                <div class="list-item">
                    <h3>Tanggal Lahir</h3>
                    <p><?= $anak["tanggal_lahir"] ?></p>
                </div>
                <div class="list-item">
                    <h3>Tempat Lahir</h3>
                    <p><?= $anak["tempat_lahir"] ?></p>
                </div>
                <div class="list-item">
                    <h3>Jenis kelamin</h3>
                    <p><?= $anak["jenis_kelamin"] ?></p>
                </div>
                <div class="list-item">
                    <h3>Nama Ayah</h3>
                    <p><?= isset($anak["nama_ayah"]) ? $anak["nama_ayah"] : "-" ?></p>
                </div>
                <div class="list-item">
                    <h3>Nama Ibu</h3>
                    <p><?= isset($anak["nama_ibu"]) ? $anak["nama_ibu"] : "-" ?></p>
                </div>
            </div>
        </div>
        <div class="container-right">
            <div class="container-top">
                <h1>Daftar Imunisasi</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Imunisasi</th>
                            <th>Tempat Imunisasi</th>
                            <th>Jadwal Pencatatan</th>
                            <th>Status Imunisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($imunisasi)) : ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Data tidak tersedia</td>
                            </tr>
                        <?php else : ?>
                            <?php
                            $i = 1;
                            $status = null;

                            foreach ($imunisasi as $imn) :

                                if ($imn["status_imunisasi"] == "Sudah") {
                                    $status = "success";
                                } else if ($imn["status_imunisasi"] == "Tertunda") {
                                    $status = "warning";
                                } else {
                                    $status = "error";
                                } ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= isset($imn["nama_imunisasi"]) ? $imn["nama_imunisasi"] : "-" ?></td>
                                    <td><?= $imn["tempat_imunisasi"] ?></td>
                                    <td><?= $imn["tanggal_imunisasi"] ?></td>
                                    <td>
                                        <div class="badge <?= $status ?>"><?= $imn["status_imunisasi"] ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="container-bottom">
                <h1>Diagram Pertumbuhan</h1>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>