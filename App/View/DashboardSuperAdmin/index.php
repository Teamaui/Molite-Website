<!-- Main Content -->
<div class="main-content">
    <div class="header">
        <h1>Dashboard</h5>
            <p><?php
                date_default_timezone_set("Asia/Jakarta");
                echo date("d F Y, H:i");
                ?></p>
            <div class="card-header">
                <div class="left-header">
                    <h1>Selamat datang, <span>Abdullah Muchsin</span></h1>
                    <p>Sehatmu, semangat kami! Terus layani dengan hati untuk kesehatan yang lebih baik.</p>
                </div>
                <div class="right-header">
                    <img src="<?= UrlHelper::img("assets/robot-molita.png") ?>" alt="" class="top">
                </div>
            </div>
    </div>
    <div class="cards-layout">
        <h3>Overview</h3>
        <div class="card-view">
            <div class="card">
                <div class="img">
                    <i class="bi bi-person-heart"></i>
                </div>
                <div class="teks">
                    <h1><?= $totalData[0] ?></h1>
                    <p>Jumlah Orang Tua</p>
                </div>
            </div>
            <div class="card">
                <div class="img img-2">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div class="teks">
                    <h1><?= $totalData[1] ?></h1>
                    <p>Jumlah Anak</p>
                </div>
            </div>
            <div class="card">
                <div class="img"><i class="bi bi-capsule"></i></div>
                <div class="teks">
                    <h1><?= $totalData[2] ?></h1>
                    <p>Jenis Imunisasi</p>
                </div>
            </div>
            <div class="card">
                <div class="img"><i class="bi bi-mortarboard-fill"></i></div>
                <div class="teks">
                    <h1><?= $totalData[3] ?></h1>
                    <p>Jenis Edukasi</p>
                </div>
            </div>
        </div>
    </div>
    <div class="diagram-layout">
        <h3>Diagram Overview</h3>
        <div class="diagram-view">
            <div class="circle-diagram">
                <canvas id="myDoughnutChart"></canvas>
            </div>
            <div class="flow-diagram">
                <canvas id="waveChart"></canvas>
            </div>
        </div>
    </div>
</div>