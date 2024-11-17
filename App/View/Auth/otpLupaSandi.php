<!-- Start Body -->
<img src="<?= UrlHelper::img("assets/bg-corner.png") ?>" alt="" class="top-left">
<img src="<?= UrlHelper::img("assets/bg-corner.png") ?>" alt="" class="top-right">

<div class="main otp">
    <?php if (FlashMessageHelper::has("pesan_sukses")) : ?>
        <p class="alert-message-success"><?= FlashMessageHelper::get("pesan_sukses"); ?></p>
    <?php endif; ?>

    <?php if (FlashMessageHelper::has("pesan_gagal")) : ?>
        <p class="alert-message-danger"><?= FlashMessageHelper::get("pesan_gagal"); ?></p>
    <?php endif; ?>
    <h1>Verifikasi OTP</h1>
    <h2>Kode akan dikirim ke email</h2>
    <p>abdullahmuchsin96@gmail.com</p>

    <form action="<?= UrlHelper::route("otp-lupa-sandi") ?>" method="post">
        <div class="card-code">
            <input type="hidden" name="id_admin" value="<?= $idAdmin ?>">
            <input type="text" name="1" class="cell" maxlength="1">
            <input type="text" name="2" class="cell" maxlength="1">
            <input type="text" name="3" class="cell" maxlength="1">
            <input type="text" name="4" class="cell" maxlength="1">
            <input type="text" name="5" class="cell" maxlength="1">
            <input type="text" name="6" class="cell" maxlength="1">
        </div>
        <p class="time">00.30</p>

        <div class="link-kode">
            <a href="">Belum menerima kode? <span>Kirim ulang kode</span></a>
        </div>

        <button type="submit">Verifikasi</button>
    </form>

    <img src="<?= UrlHelper::img("assets/robot-molita.png") ?>" alt="" class="decoration-box">
</div>
<!-- End Body -->
<img src="<?= UrlHelper::img("assets/bg-corner.png") ?>" alt="" class="bottom-left">
<img src="<?= UrlHelper::img("assets/bg-corner.png") ?>" alt="" class="bottom-right">