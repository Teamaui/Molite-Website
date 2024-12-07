<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <div class="div">
        <div class="app-name"><img src="<?= UrlHelper::img("logo.png"); ?>" width="27" alt=""><span class="mo">Mo</span><span class="lita">lita</span></div>
    </div>
    <ul>
        <li><a href="<?= UrlHelper::route("edit-profile-super-admin"); ?>" onclick="setActive()"><i class="bi bi-person-gear"></i> Edit Profil</a></li>
        <li><a href="<?= UrlHelper::route("dashboard-super-admin") ?>" onclick="setActive()"><i class="bi bi-backspace"></i> Kembali</a></li>
    </ul>
</div>
<div class="overlay" id="overlay"></div>