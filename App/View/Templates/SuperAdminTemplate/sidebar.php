<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <div class="div">
        <div class="app-name"><img src="<?= UrlHelper::img("logo.png"); ?>" width="27" alt=""><span class="mo">Mo</span><span class="lita">lita</span></div>
    </div>
    <ul>
        <li><a href="<?= UrlHelper::route("dashboard-super-admin"); ?>" onclick="setActive()"><i class="bi bi-house-door"></i> Dashboard</a></li>
        <li><a href="<?= UrlHelper::route("admin"); ?>" onclick="setActive()"><i class="bi bi-person"></i> Data Admin</a></li>
        <li><a href="<?= UrlHelper::route("orang-tua-admin"); ?>" onclick="setActive()"><i class="bi bi-people"></i> Data Orang Tua</a></li>
        <li><a onclick="showExitAlert()"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
    </ul>
    </ul>
</div>
<div class="overlay" id="overlay"></div>