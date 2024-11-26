<?php

use App\Controller\AdminController;
use App\Controller\AnakController;
use App\Controller\ApiController;
use App\Controller\AuthController;
use App\Controller\BerandaController;
use App\Controller\DashboardController;
use App\Controller\DashboarSuperController;
use App\Controller\EditProfilController;
use App\Controller\EditProfileSuperAdminController;
use App\Controller\ImunisasiController;
use App\Controller\LaporanController;
use App\Controller\OrangTuaAdminController;
use App\Controller\OrangTuaController;
use App\Controller\PenjadwalanController;
use App\Controller\PertumbuhanController;
use App\Controller\ReportController;
use Controller\SeederController;
use Routes\Route;

// ------ ADD REQUIRE 
// Libs
require_once __DIR__ . "/../App/Libs/fpdf/fpdf.php";
require_once __DIR__ . "/../App/Libs/PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/../App/Libs/PHPMailer/src/SMTP.php";
require_once __DIR__ . "/../App/Libs/PHPMailer/src/Exception.php";

// Helper
require_once __DIR__ . "/../App/Helper/PdfHelper.php";
require_once __DIR__ . "/../App/Helper/PaginationHelper.php";
require_once __DIR__ . "/../App/Helper/UrlHelper.php";
require_once __DIR__ . "/../App/Helper/FlashMessageHelper.php";
require_once __DIR__ . "/../App/Helper/PathHelper.php";
require_once __DIR__ . "/../App/Helper/DatabaseHelper.php";
require_once __DIR__ . "/../App/Helper/ViewHeader.php";
require_once __DIR__ . "/../App/Helper/GenerateCodeHelper.php";
require_once __DIR__ . "/../App/Helper/TimeHelper.php";

// Model
require_once __DIR__ . "/../App/Model/AdminModel.php";
require_once __DIR__ . "/../App/Model/OrangTuaModel.php";
require_once __DIR__ . "/../App/Model/AnakModel.php";
require_once __DIR__ . "/../App/Model/ImunisasiModel.php";
require_once __DIR__ . "/../App/Model/PertumbuhanModel.php";
require_once __DIR__ . "/../App/Model/PenjadwalanModel.php";
require_once __DIR__ . "/../App/Model/EdukasiModel.php";
require_once __DIR__ . "/../App/Model/DashboardModel.php";
require_once __DIR__ . "/../App/Model/SuperAdminModel.php";
require_once __DIR__ . "/../App/Model/OtpModel.php";

// Controller
require_once __DIR__ . "/../App/Controller/AuthController.php";
require_once __DIR__ . "/../App/Controller/DashboardSuperController.php";
require_once __DIR__ . "/../App/Controller/DashboardController.php";
require_once __DIR__ . "/../App/Controller/SeederController.php";
require_once __DIR__ . "/../App/Controller/AnakController.php";
require_once __DIR__ . "/../App/Controller/OrangTuaController.php";
require_once __DIR__ . "/../App/Controller/BerandaController.php";
require_once __DIR__ . "/../App/Controller/ApiController.php";
require_once __DIR__ . "/../App/Controller/ImunisasiController.php";
require_once __DIR__ . "/../App/Controller/EditProfilController.php";
require_once __DIR__ . "/../App/Controller/PertumbuhanController.php";
require_once __DIR__ . "/../App/Controller/PenjadwalanController.php";
require_once __DIR__ . "/../App/Controller/EdukasiController.php";
require_once __DIR__ . "/../App/Controller/LaporanController.php";
require_once __DIR__ . "/../App/Controller/ReportController.php";
require_once __DIR__ . "/../App/Controller/AdminController.php";
require_once __DIR__ . "/../App/Controller/OrangTuaAdminController.php";
require_once __DIR__ . "/../App/Controller/EditProfileSuperAdminController.php";

// Seeder
require_once __DIR__ . "/../App/Seeder/MasterSeeder.php";

// Route
require_once __DIR__ . "/../Routes/Route.php";

// ------- ADD ROUTE
// SuperAdmin Dashboard
Route::add("GET", "/dashboard-super-admin", DashboarSuperController::class, "index");
// SuperAdmin Admin
Route::add("GET", "/admin", AdminController::class, "index");
Route::add("GET", "/admin/create", AdminController::class, "create");
Route::add("POST", "/admin/store", AdminController::class, "store");
Route::add("GET", "/admin/edit/([0-9a-zA-Z]*)", AdminController::class, "edit");
Route::add("GET", "/admin/delete/([0-9a-zA-Z]*)", AdminController::class, "destroy");
Route::add("POST", "/admin/update", AdminController::class, "update");
//Edit Profile
Route::add("POST", "/edit-profile-admin/update", EditProfileSuperAdminController::class, "update");

// Beranda
Route::add("GET", "/", BerandaController::class, "index");
Route::add("GET", "/edukasi/([0-9a-zA-Z]*)", BerandaController::class, "edukasi");

// Login
Route::add("GET", "/login", AuthController::class, "index");
Route::add("POST", "/login", AuthController::class, "index");

// Register
Route::add("GET", "/register", AuthController::class, "register");
Route::add("POST", "/register", AuthController::class, "register");

// Lupa Sandi
Route::add("GET", "/lupa-sandi", AuthController::class, "lupaSandi");
Route::add("POST", "/lupa-sandi", AuthController::class, "sendOtp");
Route::add("GET", "/otp-lupa-sandi/([0-9a-zA-Z]*)", AuthController::class, "otpLupaSandi");
Route::add("POST", "/otp-lupa-sandi", AuthController::class, "storeOtpLupaSandi");
Route::add("POST", "/ganti-sandi", AuthController::class, "gantiSandi");

// Dashboard
Route::add("GET", "/dashboard", DashboardController::class, "index");

// Orang Tua
Route::add("GET", "/orang-tua", OrangTuaController::class, "index");
Route::add("GET", "/orang-tua/create", OrangTuaController::class, "create");
Route::add("POST", "/orang-tua/store", OrangTuaController::class, "store");
Route::add("GET", "/orang-tua/edit/([0-9a-zA-Z]*)", OrangTuaController::class, "edit");
Route::add("POST", "/orang-tua/update", OrangTuaController::class, "update");
Route::add("GET", "/orang-tua/delete/([0-9a-zA-Z]*)", OrangTuaController::class, "destroy");
Route::add("GET", "/orang-tua/view/([0-9a-zA-Z]*)", OrangTuaController::class, "view");

// orang tua super admin
Route::add("GET", "/orang-tua-admin", OrangTuaAdminController::class, "index");

// Anak
Route::add("GET", "/anak", AnakController::class, "index");
Route::add("GET", "/anak/create", AnakController::class, "create");
Route::add("POST", "/anak/store", AnakController::class, "store");
Route::add("GET", "/anak/edit/([0-9a-zA-Z]*)", AnakController::class, "edit");
Route::add("POST", "/anak/update", AnakController::class, "update");
Route::add("GET", "/anak/delete/([0-9a-zA-Z]*)", AnakController::class, "destroy");
Route::add("GET", "/anak/view/([0-9a-zA-Z]*)", AnakController::class, "view");

// Imunisasi
Route::add("GET", "/imunisasi", ImunisasiController::class, "index");
Route::add("GET", "/imunisasi/create", ImunisasiController::class, "create");
Route::add("POST", "/imunisasi/store", ImunisasiController::class, "store");
Route::add("GET", "/imunisasi/create", ImunisasiController::class, "create");
Route::add("POST", "/imunisasi/store", ImunisasiController::class, "store");
Route::add("GET", "/imunisasi/view/([0-9a-zA-Z]*)", ImunisasiController::class, "view");
Route::add("GET", "/imunisasi/edit/([0-9a-zA-Z]*)", ImunisasiController::class, "edit");
Route::add("POST", "/imunisasi/update", ImunisasiController::class, "update");

// Pertumbuhan
Route::add("GET", "/pertumbuhan", PertumbuhanController::class, "index");
Route::add("GET", "/pertumbuhan/create", PertumbuhanController::class, "create");
Route::add("POST", "/pertumbuhan/store", PertumbuhanController::class, "store");
Route::add("GET", "/pertumbuhan/edit/([0-9a-zA-Z]*)", PertumbuhanController::class, "edit");
Route::add("POST", "/pertumbuhan/update", PertumbuhanController::class, "update");

// Penjadwalan
Route::add("GET", "/penjadwalan", PenjadwalanController::class, "index");
Route::add("GET", "/penjadwalan/create", PenjadwalanController::class, "create");
Route::add("POST", "/penjadwalan/store", PenjadwalanController::class, "store");
Route::add("GET", "/penjadwalan/edit/([0-9a-zA-Z]*)", PenjadwalanController::class, "edit");
Route::add("POST", "/penjadwalan/update", PenjadwalanController::class, "update");
Route::add("GET", "/penjadwalan/posyandu", PenjadwalanController::class, "posyandu");
Route::add("GET", "/penjadwalan/posyandu/create", PenjadwalanController::class, "createPosyandu");
Route::add("POST", "/penjadwalan/posyandu/store", PenjadwalanController::class, "storePosyandu");
Route::add("GET", "/penjadwalan/posyandu/edit/([0-9a-zA-Z]*)", PenjadwalanController::class, "editPosyandu");
Route::add("POST", "/penjadwalan/posyandu/update", PenjadwalanController::class, "updatePosyandu");
Route::add("GET", "/penjadwalan/posyandu/delete/([0-9a-zA-Z]*)", PenjadwalanController::class, "destroyPosyandu");
Route::add("GET", "/penjadwalan/delete/([0-9a-zA-Z]*)", PenjadwalanController::class, "destroy");

// Edukasi
Route::add("GET", "/edukasi", EdukasiController::class, "index");
Route::add("GET", "/edukasi/create", EdukasiController::class, "create");
Route::add("POST", "/edukasi/store", EdukasiController::class, "store");
Route::add("GET", "/edukasi/detail-edukasi/([0-9a-zA-Z]*)", EdukasiController::class, "detailJenis");
Route::add("POST", "/edukasi/detail-edukasi/store", EdukasiController::class, "storeDetailJenis");
Route::add("GET", "/edukasi/view/([0-9a-zA-Z]*)", EdukasiController::class, "view");
Route::add("GET", "/edukasi/edit-jenis/([0-9a-zA-Z]*)", EdukasiController::class, "editJenis");
Route::add("POST", "/edukasi/update-jenis", EdukasiController::class, "updateJenis");
Route::add("GET", "/edukasi/edit-detail-edukasi/([0-9a-zA-Z]*)", EdukasiController::class, "editDetailEdukasi");
Route::add("POST", "/edukasi/detail-edukasi/update", EdukasiController::class, "updateDetailEdukasi");
Route::add("GET", "/edukasi/delete-detail-edukasi/([0-9a-zA-Z]*)", EdukasiController::class, "destroyDetailEdukasi");

// LAPORAN
Route::add("GET", "/cetak-laporan", LaporanController::class, "index");

// Cetak-Laporan
Route::add("GET", "/cetak-laporan/cetak", ReportController::class, "generateReport");

// Edit Profil
Route::add("GET", "/edit-profile", EditProfilController::class, "index");
Route::add("POST", "/edit-profile/update", EditProfilController::class, "update");

// Edit Profil Super Admin
Route::add("GET", "/edit-profile-super-admin", EditProfileSuperAdminController::class, "index");
Route::add("POST", "/edit-profile-super-admin/update", EditProfileSuperAdminController::class, "update");

// Seeder
Route::add("GET", "/seeder/run", SeederController::class, "run");
Route::add("GET", "/seeder/rollback", SeederController::class, "rollback");
Route::add("GET", "/seeder/rerun", SeederController::class, "rerun");

// Api Molita
Route::add("GET", "/molita-api/get-orang-tua", ApiController::class, "getOrangTua");
Route::add("GET", "/molita-api/get-pertumbuhan", ApiController::class, "getPertumbuhan");
Route::add("GET", "/molita-api/get-pertumbuhan/([0-9a-zA-Z]*)", ApiController::class, "getPertumbuhanById");
Route::add("GET", "/molita-api/get-status-imunisasi", ApiController::class, "getStatusImunisasi");
Route::add("POST", "/molita-api/register-orang-tua", ApiController::class, "registerOrangTua");
Route::add("POST", "/molita-api/login-orang-tua", ApiController::class, "loginOrangTua");
Route::add("GET", "/molita-api/get-edukasi", ApiController::class, "getDataEdukasi");
Route::add("POST", "/molita-api/update-like-user-edukasi", ApiController::class, "likeUserEdukasi");
Route::add("GET", "/molita-api/get-admin/([0-9a-zA-Z]*)", ApiController::class, "getDataAdminById");
Route::add("GET", "/molita-api/get-orang-tua/([0-9a-zA-Z]*)", ApiController::class, "getDataOrangTuaById");

// Logout
Route::add("GET", "/logout", AuthController::class, "logout");

// ---- RUN ROUTE
Route::run();
