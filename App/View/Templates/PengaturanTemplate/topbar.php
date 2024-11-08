    <!-- Topbar -->
    <div class="topbar">
        <div class="app-name"><img src="<?= UrlHelper::img("logo.png"); ?>" width="27" alt=""><span class="mo">Mo</span><span class="lita">lita</span></div>
        <div class="user-section">
            <div class="user-name" onclick="toggleDropdown()"><?= $admin["nama_admin"] ?> ▼</div>
            <div class="dropdown" id="dropdownMenu">
                <a href="<?= UrlHelper::route("dashboard") ?>"><i class="bi bi-house-gear"></i> Dashboard</a>
                <a onclick="showExitAlert()"><i class="bi bi-box-arrow-left"></i> Keluar</a>
            </div>
        </div>
    </div>