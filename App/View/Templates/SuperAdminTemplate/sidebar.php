    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="<?= UrlHelper::route("dashboard-super-admin"); ?>" onclick="setActive()"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="<?= UrlHelper::route("admin"); ?>" onclick="setActive()"><i class="bi bi-person"></i> Data Admin</a></li>
            <li><a href="<?= UrlHelper::route("orang-tua-admin"); ?>" onclick="setActive()"><i class="bi bi-people"></i> Data Orang Tua</a></li>
            <li><a onclick="showExitAlert()"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
        </ul>
    </div>