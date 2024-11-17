function togglePassword(input, icon) {
  const type = input.getAttribute("type") === "password" ? "text" : "password";
  input.setAttribute("type", type);

  icon.classList.toggle("bi-eye-fill", type === "text");
  icon.classList.toggle("bi-eye-slash-fill", type === "password");
}

const tombolSandi1 = document.querySelector("#toggle-password1");
const iconSandi1 = document.querySelector("#toggle-password1 i");
const sandi1 = document.querySelector("#sandi1");

if (tombolSandi1 && iconSandi1 && sandi1) {
  tombolSandi1.addEventListener("click", () =>
    togglePassword(sandi1, iconSandi1)
  );
}

const tombolSandi2 = document.querySelector("#toggle-password2");
const iconSandi2 = document.querySelector("#toggle-password2 i");
const sandi2 = document.querySelector("#sandi2");

if (tombolSandi2 && iconSandi2 && sandi2) {
  tombolSandi2.addEventListener("click", () =>
    togglePassword(sandi2, iconSandi2)
  );
}

const tombolSandi3 = document.querySelector("#toggle-password3");
const iconSandi3 = document.querySelector("#toggle-password3 i");
const sandi3 = document.querySelector("#sandi3");

if (tombolSandi3 && iconSandi3 && sandi3) {
  tombolSandi3.addEventListener("click", () =>
    togglePassword(sandi3, iconSandi3)
  );
}

// Register
const tombolSandiRegister1 = document.querySelector(
  "#toggle-register-password1"
);
const iconSandiRegister1 = document.querySelector(
  "#toggle-register-password1 i"
);
const sandi_register1 = document.querySelector("#sandi_register1");

if (tombolSandiRegister1 && iconSandiRegister1 && sandi_register1) {
  tombolSandiRegister1.addEventListener("click", () =>
    togglePassword(sandi_register1, iconSandiRegister1)
  );
}

const tombolSandiRegister2 = document.querySelector(
  "#toggle-register-password2"
);
const iconSandiRegister2 = document.querySelector(
  "#toggle-register-password2 i"
);
const sandi_register2 = document.querySelector("#sandi_register2");

if (tombolSandiRegister2 && iconSandiRegister2 && sandi_register2) {
  tombolSandiRegister2.addEventListener("click", () =>
    togglePassword(sandi_register2, iconSandiRegister2)
  );
}

// Ganti Sandi
const tombolGantiSandi1 = document.querySelector(
  "#toggle-ganti-password1"
);
const iconGantiSandi1 = document.querySelector(
  "#toggle-ganti-password1 i"
);
const sandi_ganti1 = document.querySelector("#gantiSandi1");

if (tombolGantiSandi1 && iconGantiSandi1 && sandi_ganti1) {
  tombolGantiSandi1.addEventListener("click", () =>
    togglePassword(sandi_ganti1, iconGantiSandi1)
  );
}

const tombolGantiSandi2 = document.querySelector(
  "#toggle-ganti-password2"
);
const iconGantiSandi2 = document.querySelector(
  "#toggle-ganti-password2 i"
);
const ganti_sandi2 = document.querySelector("#gantiSandi2");

if (tombolGantiSandi2 && iconGantiSandi2 && ganti_sandi2) {
  tombolGantiSandi2.addEventListener("click", () =>
    togglePassword(ganti_sandi2, iconGantiSandi2)
  );
}
