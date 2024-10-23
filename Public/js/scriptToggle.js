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
