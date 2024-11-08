<div id="exitAlert" class="alert-container">
    <div class="alert-box">
        <p>Apakah Anda yakin ingin keluar?</p>
        <a href="<?= UrlHelper::route("logout"); ?>" onclick="confirmExit()" class="alert-button confirm">Ya</a>
        <a onclick="closeExitAlert()" class="alert-button cancel">Tidak</a>
    </div>
</div>

<!-- JavaScript -->
<script>
    function displayFileName() {
        const fileInput = document.getElementById('file-input');
        const fileName = document.getElementById('file-name');
        fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : "Belum ada file yang dipilih";
    }
</script>
<script>
    // Data penjualan dan pembelian
    const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli"];
    const dataBeratBadan = [900, 400, 800, 600, 700, 800, 900];
    const dataTinggiBadan = [500, 300, 400, 500, 600, 700, 800];
    const dataLingkarKepala = [300, 500, 600, 500, 600, 700, 800];

    const data = {
        labels: labels,
        datasets: [{
                label: "Berat Badan",
                data: dataBeratBadan,
                borderColor: "rgb(75, 192, 192)",
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                fill: true,
                tension: 0.4,
            },
            {
                label: "Tinggi Badan",
                data: dataTinggiBadan,
                borderColor: "rgb(255, 99, 132)",
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                fill: true,
                tension: 0.4,
            },
            {
                label: "Lingkar kepala",
                data: dataLingkarKepala,
                borderColor: "rgba(255, 100, 86, 0.2)",
                backgroundColor: "rgba(255, 206, 86, 0.2)",
                fill: true,
                tension: 0.4,
            },
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Render chart
    const myChart = new Chart(
        document.getElementById('waveChart'),
        config
    );
</script>
<script>
    // JavaScript untuk menginisialisasi Chart.js
    const ctx2 = document.getElementById('myDoughnutChart').getContext('2d');
    const myDoughnutChart = new Chart(ctx2, {
        type: 'doughnut', // jenis chart
        data: {
            labels: ['Belum', 'Tertunda', 'Sudah'], // Label data
            datasets: [{
                label: 'Contoh Data',
                data: [10, 20, 30], // Data masing-masing bagian
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
<script>
    // Fungsi untuk mengambil data dari PHP
    async function fetchData(url) {
        try {
            const response = await fetch(url);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching data:', error);
            return [];
        }
    }

    // Fungsi untuk memproses data menjadi format yang sesuai untuk Chart.js
    function processData(data) {
        const labels = data.map(item => item.bulan_pencatatan); // Label bulan
        const dataBeratBadan = data.map(item => item.berat_badan); // Data penjualan
        const dataTinggiBadan = data.map(item => item.tinggi_badan); // Data pembelian
        const dataLingkarkepala = data.map(item => item.lingkar_kepala); // Data pembelian

        return {
            labels,
            dataBeratBadan,
            dataTinggiBadan,
            dataLingkarkepala
        };
    }

    // Fungsi untuk membuat diagram batang dengan Chart.js
    function createBarChart(labels, dataBeratBadan, dataTinggiBadan, dataLingkarKepala) {
        const ctx3 = document.getElementById('barChart').getContext('2d');

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Berat Badan',
                        data: dataBeratBadan,
                        backgroundColor: 'rgba(102, 204, 0, 0.6)',
                        borderWidth: 1
                    },
                    {
                        label: 'Tinggi Badan',
                        data: dataTinggiBadan,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderWidth: 1
                    },
                    {
                        label: 'Lingkar Kepala',
                        data: dataLingkarKepala,
                        backgroundColor: 'rgba(23, 162, 184, 0.6)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Fungsi utama untuk mengatur alur eksekusi
    async function main() {
        const data = await fetchData('http://localhost/Molita/Public/index.php/molita-api/get-pertumbuhan'); // Mengambil data dari PHP
        const {
            labels,
            dataBeratBadan,
            dataTinggiBadan,
            dataLingkarkepala
        } = processData(data.data); // Memproses data
        createBarChart(labels, dataBeratBadan, dataTinggiBadan, dataLingkarkepala);
    }

    // Memulai fungsi utama
    main();
</script>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMenu");
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            dropdown.style.display = "block";
        }
    }

    window.onclick = function(event) {
        if (!event.target.matches('.user-name')) {
            var dropdown = document.getElementById("dropdownMenu");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            }
        }
    }

    function setActive() {
        var currentPath = window.location.pathname; // Mendapatkan seluruh path dari URL
        var links = document.querySelectorAll('.sidebar a');

        links.forEach(link => {
            var linkPath = new URL(link.href).pathname; // Mendapatkan path dari href link

            // Cek apakah currentPath mengandung linkPath (misalnya, /dashboard di dalam /dashboard/create)
            if (currentPath.includes(linkPath)) {
                link.classList.add('active'); // Menambahkan kelas 'active' pada link yang sesuai
                changeIcon(link); // Mengganti ikon untuk link aktif
            } else {
                link.classList.remove('active'); // Menghapus kelas 'active' jika link tidak cocok
                resetIcon(link); // Mengembalikan ikon ke keadaan semula untuk link yang tidak aktif
            }
        });
    }

    // Fungsi untuk mengganti ikon saat link aktif
    function changeIcon(link) {
        var icon = link.querySelector('i'); // Mendapatkan elemen ikon di dalam link

        if (icon) {
            // Mengganti ikon berdasarkan kelas ikon saat ini
            if (icon.classList.contains('bi-house-door')) {
                icon.classList.replace('bi-house-door', 'bi-house-door-fill');
            } else if (icon.classList.contains('bi-emoji-smile')) {
                icon.classList.replace('bi-emoji-smile', 'bi-emoji-smile-fill');
            } else if (icon.classList.contains('bi-person')) {
                icon.classList.replace('bi-person', 'bi-person-fill');
            } else if (icon.classList.contains('bi-bandaid')) {
                icon.classList.replace('bi-bandaid', 'bi-bandaid-fill');
            } else if (icon.classList.contains('bi-clipboard-data')) {
                icon.classList.replace('bi-clipboard-data', 'bi-clipboard-data-fill');
            } else if (icon.classList.contains('bi-calendar-week')) {
                icon.classList.replace('bi-calendar-week', 'bi-calendar-week-fill');
            } else if (icon.classList.contains('bi-file-text')) {
                icon.classList.replace('bi-file-text', 'bi-file-text-fill');
            } else if (icon.classList.contains('bi-printer')) {
                icon.classList.replace('bi-printer', 'bi-printer-fill');
            }
        }
    }

    // Fungsi untuk mengembalikan ikon ke keadaan semula saat link tidak aktif
    function resetIcon(link) {
        var icon = link.querySelector('i'); // Mendapatkan elemen ikon di dalam link

        if (icon) {
            // Kembalikan ikon ke versi awalnya
            if (icon.classList.contains('bi-house-door-fill')) {
                icon.classList.replace('bi-house-door-fill', 'bi-house-door');
            } else if (icon.classList.contains('bi-emoji-smile-fill')) {
                icon.classList.replace('bi-emoji-smile-fill', 'bi-emoji-smile');
            } else if (icon.classList.contains('bi-person-fill')) {
                icon.classList.replace('bi-person-fill', 'bi-person');
            } else if (icon.classList.contains('bi-bandaid-fill')) {
                icon.classList.replace('bi-bandaid-fill', 'bi-bandaid');
            } else if (icon.classList.contains('bi-clipboard-data-fill')) {
                icon.classList.replace('bi-clipboard-data-fill', 'bi-clipboard-data');
            } else if (icon.classList.contains('bi-calendar-week-fill')) {
                icon.classList.replace('bi-calendar-week-fill', 'bi-calendar-week');
            } else if (icon.classList.contains('bi-file-text-fill')) {
                icon.classList.replace('bi-file-text-fill', 'bi-file-text');
            } else if (icon.classList.contains('bi-printer-fill')) {
                icon.classList.replace('bi-printer-fill', 'bi-printer');
            }
        }
    }

    // Menandai link sidebar berdasarkan URL saat ini
    document.addEventListener("DOMContentLoaded", setActive);

    // Menampilkan alert konfirmasi keluar
    function showExitAlert() {
        document.getElementById("exitAlert").style.display = "flex";
    }

    // Menutup alert konfirmasi keluar
    function closeExitAlert() {
        document.getElementById("exitAlert").style.display = "none";
    }

    // Foto
    const photoInput = document.getElementById('file-input');
    const photoPreview = document.getElementById('photo-preview');

    photoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.style.border = "2px solid #098DB3";
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.style.border = "none";
        }
    });

    function displayFileName() {
        const fileInput = document.getElementById('file-input');
        const fileName = document.getElementById('file-name');
        fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : "Belum ada file yang dipilih";
    }
</script>
</body>

</html>