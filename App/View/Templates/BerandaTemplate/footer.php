<div class="footer-bottom">
    <p>&#169; <?= date("Y") ?> Molita. Semua hak cipta dilindung.</p>
</div>

<script>
    // Inisialisasi map pada elemen dengan id "map"
    var map = L.map('map', {
        attributionControl: false // Menghapus kontrol atribusi bawaan
    }).setView([-8.1724, 113.6995], 13);

    // Tambahkan tile layer tanpa kontrol atribusi bawaan
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    L.control.attribution({
        prefix: false // Menghapus "Powered by Leaflet"
    }).addAttribution('© OpenStreetMap contributors').addTo(map);

    // Tambahkan marker di lokasi tertentu
    L.marker([-8.1724, 113.6995]).addTo(map)
        .bindPopup('Ini Molita!')
        .openPopup();

    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('active');
    }


    window.addEventListener("scroll", function() {
        const topbar = document.querySelector(".topbar");
        let scrollPos = window.scrollY;

        if (scrollPos > 20) { // Jika discroll lebih dari 10px
            topbar.style.backdropFilter = "blur(10px)";
        } else {
            topbar.style.backdropFilter = "blur(0px)";
        }
    });

    const swiperContainer = document.querySelector(".container-card");
    const cards = document.querySelectorAll(".card");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    const indicatorsContainer = document.querySelector(".indicators");

    // Konfigurasi jumlah kartu yang tampil
    let cardsPerView = 3; // Ubah angka ini untuk jumlah kartu yang ditampilkan
    const totalCards = cards.length;
    let currentIndex = 0;

    // Fungsi untuk memperbarui jumlah kartu yang ditampilkan berdasarkan lebar layar
    if (window.matchMedia("(max-width: 768px)").matches) {
        cardsPerView = 1; // Menampilkan 1 kartu untuk layar kecil
    } else {
        cardsPerView = 3; // Kembali ke default
    }

    // Membuat indikator
    for (let i = 0; i < Math.ceil(totalCards / cardsPerView); i++) {
        const indicator = document.createElement("span");
        indicator.classList.add("indicator");
        if (i === 0) indicator.classList.add("active");
        indicatorsContainer.appendChild(indicator);
    }

    const indicators = document.querySelectorAll(".indicator");

    // Menampilkan kartu sesuai indeks
    function showCards(index) {
        const offset = index * cardsPerView;
        const containerWidth = swiperContainer.offsetWidth;
        const translateX = -offset * (containerWidth / cardsPerView);

        cards.forEach((card) => {
            card.style.transform = `translateX(${translateX}px)`;
        });

        updateIndicators(index);
    }

    // Memperbarui indikator
    function updateIndicators(index) {
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle("active", i === index);
        });
    }

    // Navigasi ke set kartu berikutnya
    function nextCards() {
        currentIndex = Math.min(
            currentIndex + 1,
            Math.ceil(totalCards / cardsPerView) - 1
        );
        showCards(currentIndex);
    }

    // Navigasi ke set kartu sebelumnya
    function prevCards() {
        currentIndex = Math.max(currentIndex - 1, 0);
        showCards(currentIndex);
    }

    // Event listener tombol navigasi
    nextBtn.addEventListener("click", nextCards);
    prevBtn.addEventListener("click", prevCards);

    // Event listener indikator
    indicators.forEach((indicator, i) => {
        indicator.addEventListener("click", () => {
            currentIndex = i;
            showCards(currentIndex);
        });
    });

    // Geser otomatis
    function startAutoSlide() {
        return setInterval(() => {
            if (currentIndex === Math.ceil(totalCards / cardsPerView) - 1) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            showCards(currentIndex);
        }, 3000);
    }

    let autoSlideInterval = startAutoSlide();

    // Hentikan geser otomatis saat hover
    swiperContainer.addEventListener("mouseenter", () =>
        clearInterval(autoSlideInterval)
    );
    swiperContainer.addEventListener(
        "mouseleave",
        () => (autoSlideInterval = startAutoSlide())
    );

    // Menampilkan set kartu pertama
    showCards(currentIndex);
</script>
</body>

</html>