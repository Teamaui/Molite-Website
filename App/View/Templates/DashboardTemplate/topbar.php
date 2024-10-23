    <!-- Topbar -->
    <div class="topbar">
        <div class="app-name"><img src="../img/logo.png" width="27" alt=""><span class="mo">Mo</span><span class="lita">lita</span></div>
        <div class="user-section">
            <div class="user-name" onclick="toggleDropdown()"><?= $admin["nama_admin"] ?> ▼</div>
            <div class="dropdown" id="dropdownMenu">
                <a href="#"><i class="bi bi-pencil"></i> Edit Profil</a>
                <a href="/logout"><i class="bi bi-box-arrow-left"></i> Keluar</a>
            </div>
        </div>
    </div>