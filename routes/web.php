<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});
Route::group(['middleware' => ['auth']], function () {
    // Roles
    Route::resource('roles', App\Http\Controllers\RolesController::class);

    // Country
    Route::resource('countries', App\Http\Controllers\CountryController::class);
    Route::get('countries-export/', [App\Http\Controllers\CountryController::class, 'export'])->name('countries-export');
    Route::get('getcountries/', [App\Http\Controllers\CountryController::class, 'getCountries'])->name('getCountries');

    // State
    Route::resource('states', App\Http\Controllers\StateController::class);
    Route::get('states-export/', [App\Http\Controllers\StateController::class, 'export'])->name('states-export');
    Route::get('getstates/', [App\Http\Controllers\StateController::class, 'getStates'])->name('getStates');

    // City
    Route::resource('cities', App\Http\Controllers\CityController::class);
    Route::get('cities-export/', [App\Http\Controllers\CityController::class, 'export'])->name('cities-export');
    Route::get('getcities/', [App\Http\Controllers\CityController::class, 'getCities'])->name('getCities');

    // Pincode
    Route::resource('pincodes', App\Http\Controllers\PincodeController::class);
    Route::get('pincodes-export/', [App\Http\Controllers\PincodeController::class, 'export'])->name('pincodes-export');
    Route::get('getpincodes/', [App\Http\Controllers\PincodeController::class, 'getPincodes'])->name('getPincodes');

    // Permissions
    Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

    // Vendors
    Route::resource('vendors', App\Http\Controllers\VendorController::class);
    Route::get('/update/status/{user_id}/{status}', [VendorController::class, 'updateStatus'])->name('vendors-status');

    Route::post('search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

});

// Users 
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');


    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

    Route::get('export/', [UserController::class, 'export'])->name('export');

});

