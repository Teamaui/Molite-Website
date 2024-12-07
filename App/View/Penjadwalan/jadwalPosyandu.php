<!-- Main Content -->
<div class="main-content">
    <h1 class="txt-edu active">Daftar Jadwal Pos : <?= $jenisPosyandu["pos"] ?></h1>
    <h1 class="txt-edu">Tambah Jadwal Posyandu</h1>
    <div class="table-container">
        <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
            <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
        <?php endif; ?>

        <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
            <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
        <?php endif; ?>

        <div class="tabs-nav">
            <button class="tab-btn active" data-tab="tab1">Lihat Data</button>
            <button class="tab-btn" data-tab="tab2">Tambah Data</button>
        </div>

        <hr>

        <div class="tabs-content main-container">
            <!-- Tabs Untuk Menampilkan daftar data -->
            <div class="left tab-pane active" id="tab1">
                <div class="table-button">
                    <div><a href="<?= UrlHelper::route("penjadwalan/posyandu") ?>" onclick="setActive()"><i class="bi bi-backspace"></i> Kembali</a></div>
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
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $startNumber = 1;
                        foreach ($posyandu as $psy) : ?>
                            <tr>
                                <td><?= $startNumber++ ?></td>
                                <td><?= TimeHelper::formatTanggal($psy["tanggal"]) ?></td>
                                <td><?= TimeHelper::formatWaktuIndonesia($psy["jam_mulai"]) ?> - <?= TimeHelper::formatWaktuIndonesia($psy["jam_selesai"])  ?></td>
                                <td>
                                    <a class="edit" href="<?= UrlHelper::route("penjadwalan/posyandu/view/edit/" . $psy["id_jadwal_posyandu"]) ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <a class="hapus" href="<?= UrlHelper::route("penjadwalan/posyandu/view/delete/" . $psy["id_jadwal_posyandu"]) ?>"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["search"])) : ?>
                    <?= App\Helper\PaginationHelper::renderSearch((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('penjadwalan/posyandu/view/' . $pagination["id_posyandu"] . '?page='), $_GET["search"]) ?>
                <?php else : ?>
                    <?= App\Helper\PaginationHelper::render((isset($_GET["page"]) ? $_GET["page"] : 1), $pagination["totalPages"], UrlHelper::route('penjadwalan/posyandu/view/' . $pagination["id_posyandu"] . '?page=')) ?>
                <?php endif; ?>
            </div>

            <!-- Tabs untuk tambah data -->
            <form id="tab2" class="tab-pane" action="<?= UrlHelper::route("penjadwalan/posyandu/view/store"); ?>" method="post">
                <div class="form-container">
                    <div class="form-left">
                        <input type="hidden" name="id_posyandu" value="<?= $pagination["id_posyandu"] ?>">
                        <div>
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" placeholder="Masukkan Nama Imunisasi..." name="tanggal" required>
                        </div>
                        <div>
                            <label for="jam_mulai">Jam Posyandu</label>
                            <div class="jam">
                                <input type="time" id="jam_mulai" name="jam_mulai" required>
                                <div class="garis"> - </div>
                                <input type="time" id="jam_selesai" name="jam_selesai" required>
                            </div>
                            <small id="error-message" style="color: red; display: none;">Jam mulai tidak boleh lebih besar dari jam selesai.</small>
                        </div>
                    </div>
                </div>
                <button type="submit" id="btn-jam">Tambah Data</button>
            </form>
        </div>
    </div>
</div>