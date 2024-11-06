    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="<?= UrlHelper::route("dashboard"); ?>" onclick="setActive()"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="<?= UrlHelper::route("orang-tua"); ?>" onclick="setActive()"><i class="bi bi-person"></i> Data Orang Tua</a></li>
            <li><a href="<?= UrlHelper::route("anak"); ?>"><i class="bi bi-emoji-smile"></i> Data Anak</a></li>
            <li><a href="<?= UrlHelper::route("pertumbuhan"); ?>"><i class="bi bi-clipboard-data"></i> Pertumbuhan</a></li>
            <li><a href="<?= UrlHelper::route("imunisasi"); ?>" onclick="setActive()"><i class="bi bi-bandaid"></i> Imunisasi</a></li>
            <li><a href="<?= UrlHelper::route("penjadwalan"); ?>" onclick="setActive()"><i class="bi bi-calendar-week"></i> Penjadwalan</a></li>
            <li><a href="<?= UrlHelper::route("edukasi"); ?>" onclick="setActive()"><i class="bi bi-file-text"></i> Edukasi</a></li>
            <li><a href="<?= UrlHelper::route("customer-service"); ?>" onclick="setActive()"><i class="bi bi-telephone"></i> Customer Service</a></li>
            <li><a href="<?= UrlHelper::route("cetak-laporan"); ?>" onclick="setActive()"><i class="bi bi-printer"></i> Cetak Laporan</a></li>
            <li><a onclick="showExitAlert()"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
        </ul>
    </div>