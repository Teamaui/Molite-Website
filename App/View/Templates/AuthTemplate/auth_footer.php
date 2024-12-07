<script src="../js/scriptToggle.js"></script>
<script>
    // Durasi waktu dalam detik
    let countdown = 30;

    // Elemen yang akan diperbarui
    const timeElement = document.querySelector('.time');
    const linkElement = document.querySelector('.link-kode');

    // Fungsi untuk memformat waktu (mm:ss)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    // Fungsi untuk menjalankan hitungan mundur
    function startCountdown() {
        const timer = setInterval(() => {
            countdown--;
            timeElement.textContent = formatTime(countdown);

            // Ketika waktu habis
            if (countdown <= 0) {
                clearInterval(timer); // Hentikan timer
                timeElement.textContent = '00:00'; // Tampilkan 00:00
                linkElement.style.display = 'flex'; // Tampilkan tautan
            }
        }, 1000); // Jalankan setiap 1 detik
    }

    // Mulai hitungan mundur
    startCountdown();
</script>

</body>

</html>