<!-- Main Content -->
<div class="main-content">
    <h1>Edit Data Admin</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("admin/update"); ?>" method="post">
            <div class="form-container">
                <div class="form-left">
                    <input type="hidden" name="id_admin"value="<?= $admin["id_admin"] ?>">
                    <div>
                        <label for="nik">NIK</label>
                        <input type="text" id="nik" value="<?= $admin["nik"] ?>" placeholder="Masukkan NIK..." name="nik" required>
                    </div>
                    <div>
                        <label for="nama_admin">Nama Admin</label>
                        <input type="text" id="nama_admin" value="<?= $admin["nama_admin"] ?>" placeholder="Masukkan Nama Admin..." name="nama_admin" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="text" id="email" value="<?= $admin["email"] ?>" placeholder="Masukkan Email..." name="email" required>
                    </div>
                </div>
                <div class="form-left">
                </div>
            </div>
            <button type="submit">Edit Data</button>
        </form>
    </div>
</div>