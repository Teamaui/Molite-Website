<?php

use App\Controller\AnakController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use Controller\SeederController;
use Routes\Route;

require_once __DIR__ . "/../App/Model/AdminModel.php";
require_once __DIR__ . "/../App/Seeder/MasterSeeder.php";
require_once __DIR__ . "/../App/Controller/SeederController.php";
require_once __DIR__ . "/../App/Helper/PathHelper.php";
require_once __DIR__ . "/../App/Controller/DashboardController.php";
require_once __DIR__ . "/../App/Controller/AnakController.php";
require_once __DIR__ . "/../App/Helper/DatabaseHelper.php";
require_once __DIR__ . "/../App/Helper/FlashMessageHelper.php";
require_once __DIR__ . "/../App/Helper/ViewHeader.php";
require_once __DIR__ . "/../App/Controller/AuthController.php";
require_once __DIR__ . "/../Routes/Route.php";

Route::add("GET", "/login", AuthController::class, "index");
Route::add("POST", "/login", AuthController::class, "index");

Route::add("GET", "/register", AuthController::class, "register");
Route::add("POST", "/register", AuthController::class, "register");

Route::add("GET", "/dashboard", DashboardController::class, "index");

Route::add("GET", "/anak", AnakController::class, "index");
Route::add("GET", "/anak/create", AnakController::class, "create");

Route::add("GET", "/seeder/run", SeederController::class, "run");
Route::add("GET", "/seeder/rollback", SeederController::class, "rollback");
Route::add("GET", "/seeder/rerun", SeederController::class, "rerun");

Route::add("GET", "/logout", AuthController::class, "logout");

Route::run();
