<!-- JavaScript -->
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
            var linkPath = link.getAttribute('href');

            // Cek apakah path dari link merupakan bagian dari currentPath (misalnya, /dashboard di dalam /dashboard/create)
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
            } else if (icon.classList.contains('bi-gear')) {
                icon.classList.replace('bi-gear', 'bi-gear-fill');
            } else if (icon.classList.contains('bi-box-arrow-right')) {
                icon.classList.replace('bi-box-arrow-right', 'bi-box-arrow-left');
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
            } else if (icon.classList.contains('bi-gear-fill')) {
                icon.classList.replace('bi-gear-fill', 'bi-gear');
            } else if (icon.classList.contains('bi-box-arrow-left')) {
                icon.classList.replace('bi-box-arrow-left', 'bi-box-arrow-right');
            }
        }
    }

    // Menandai link sidebar berdasarkan URL saat ini
    document.addEventListener("DOMContentLoaded", setActive);
</script>
</body>

</html>