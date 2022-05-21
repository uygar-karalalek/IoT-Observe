<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get("/userId", function () {
    $email = request("username");
    $data = request("password");
    $user = DB::table("users")->where("email", "=", $email)->get()->first();

    if ($user && Hash::check($data, $user->password)) {
        return $user->id;
    }

    return -1;
});
Route::post("/clientDevices/toProcess", [DeviceController::class, "clientDevicesToProcess"]);
Route::get('/', [IndexController::class, "index"]);
Route::get('/device', [DeviceController::class, "getAllDevices"]);
Route::post('/devices/create', [DeviceController::class, "addDevice"]);
Route::post('/device/edit', [DeviceController::class, "editDevice"]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
