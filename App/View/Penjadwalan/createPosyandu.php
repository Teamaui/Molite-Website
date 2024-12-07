<!-- Main Content -->
<div class="main-content">
    <h1>Tambah Posyandu</h1>
    <div class="main-container">
        <form action="<?= UrlHelper::route("penjadwalan/posyandu/store"); ?>" method="post">
            <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
                <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
            <?php endif; ?>

            <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
                <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
            <?php endif; ?>
            <div class="form-container">

                <div class="form-left">
                    <div>
                        <label for="nama_pos">Nama Pos</label>
                        <input type="text" id="nama_pos" placeholder="Masukkan Nama Pos..." name="nama_pos" required>
                    </div>
                </div>
            </div>
            <button type="submit">Tambah Data</button>
        </form>
    </div>
</div>