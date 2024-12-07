<div id="exitAlert" class="alert-container">
    <div class="alert-box">
        <p>Apakah Anda yakin ingin keluar?</p>
        <a href="<?= UrlHelper::route("logout"); ?>" onclick="confirmExit()" class="alert-button confirm">Ya</a>
        <a onclick="closeExitAlert()" class="alert-button cancel">Tidak</a>
    </div>
</div>

<!-- JavaScript -->
<script>
    const overlay = document.getElementById('overlay');
    const sidebar = document.getElementById('sidebar');
    const btnDropdown = document.querySelector(".sidebar button");

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
        btnDropdown.style.display = "block";
    }

    function toggleCloseSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        btnDropdown.style.display = "none";
    }

    // Tambahkan event listener untuk overlay
    overlay.addEventListener('click', toggleCloseSidebar);

    function togglePassword(input, icon) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        icon.classList.toggle('bi-eye-fill', type === 'text');
        icon.classList.toggle('bi-eye-slash-fill', type === 'password');
    }

    const tombolSandi1 = document.querySelector("#toggle-password1");
    const iconSandi1 = document.querySelector("#toggle-password1 i");
    const sandi1 = document.querySelector("#sandi1");

    if (tombolSandi1 && iconSandi1 && sandi1) {
        tombolSandi1.addEventListener("click", () => togglePassword(sandi1, iconSandi1));
    }

    const tombolSandi2 = document.querySelector("#toggle-password2");
    const iconSandi2 = document.querySelector("#toggle-password2 i");
    const sandi2 = document.querySelector("#sandi2");

    if (tombolSandi2 && iconSandi2 && sandi2) {
        tombolSandi2.addEventListener("click", () => togglePassword(sandi2, iconSandi2));
    }

    const tombolSandi3 = document.querySelector("#toggle-password3");
    const iconSandi3 = document.querySelector("#toggle-password3 i");
    const sandi3 = document.querySelector("#sandi3");

    if (tombolSandi3 && iconSandi3 && sandi3) {
        tombolSandi3.addEventListener("click", () => togglePassword(sandi3, iconSandi3));
    }


    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownMenu");
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
            if (icon.classList.contains('bi-person-gear')) {
                icon.classList.replace('bi-person-gear', 'bi-person-fill-gear');
            } else if (icon.classList.contains('bi-emoji-smile')) {
                icon.classList.replace('bi-emoji-smile', 'bi-emoji-smile-fill');
            } else if (icon.classList.contains('bi-person')) {
                icon.classList.replace('bi-person', 'bi-person-fill');
            } else if (icon.classList.contains('bi-bandaid')) {
                icon.classList.replace('bi-bandaid', 'bi-bandaid-fill');
            }
        }
    }

    // Fungsi untuk mengembalikan ikon ke keadaan semula saat link tidak aktif
    function resetIcon(link) {
        var icon = link.querySelector('i'); // Mendapatkan elemen ikon di dalam link

        if (icon) {
            // Kembalikan ikon ke versi awalnya
            if (icon.classList.contains('bi-person-fill-gear')) {
                icon.classList.replace('bi-person-fill-gear', 'bi-person-gear');
            } else if (icon.classList.contains('bi-emoji-smile-fill')) {
                icon.classList.replace('bi-emoji-smile-fill', 'bi-emoji-smile');
            } else if (icon.classList.contains('bi-person-fill')) {
                icon.classList.replace('bi-person-fill', 'bi-person');
            } else if (icon.classList.contains('bi-bandaid-fill')) {
                icon.classList.replace('bi-bandaid-fill', 'bi-bandaid');
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

    function displayFileName() {
        const fileInput = document.getElementById('file-input');
        const fileName = document.getElementById('file-name');
        fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : "Pilih foto untuk background edukasi";
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
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.style.border = "none";
        }
    });

    const submitEdit = document.getElementById('submit-edit-profile');

    sandi1.addEventListener('keyup', () => {
        if (sandi1.value.trim() !== "") {
            submitEdit.disabled = true;

            sandi2.addEventListener('input', validatePasswords);
            sandi3.addEventListener('input', validatePasswords);
        } else {
            submitEdit.disabled = true;
        }
    });

    function validatePasswords() {
        if (
            sandi2.value.length >= 8 &&
            sandi2.value === sandi3.value
        ) {
            submitEdit.disabled = false;
        } else {
            submitEdit.disabled = true;
        }
    }

    sandi1.addEventListener('input', () => {
        if (sandi1.value.trim() !== "") {
            sandi2.disabled = false;
            sandi3.disabled = false;
        } else {
            sandi2.disabled = true;
            sandi3.disabled = true;
            sandi2.value = '';
            sandi3.value = '';
            resetValidation(sandi2);
            resetValidation(sandi3);
        }
    });

    sandi2.addEventListener('input', () => {
        if (sandi2.value.length >= 8) {
            setValid(sandi2);
        } else {
            setInvalid(sandi2);
        }
        validateForm();
    });

    sandi3.addEventListener('input', () => {
        if (sandi3.value === sandi2.value && sandi3.value.length >= 8) {
            setValid(sandi3);
        } else {
            setInvalid(sandi3);
        }
        validateForm();
    });

    function setValid(element) {
        element.classList.add('valid');
        element.classList.remove('invalid');
    }

    function setInvalid(element) {
        element.classList.add('invalid');
        element.classList.remove('valid');
    }

    function resetValidation(element) {
        element.classList.remove('valid');
        element.classList.remove('invalid');
    }

    function validateForm() {
        if (
            sandi2.classList.contains('valid') &&
            sandi3.classList.contains('valid') &&
            sandi2.value === sandi3.value
        ) {
            submitEdit.disabled = false;
        } else {
            submitEdit.disabled = true;
        }
    }
</script>
</body>

</html>