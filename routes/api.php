<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|getUsers
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function () {
Route::Post('Warehouse-register', 'createWarehouseAccount')->name('Warehouse-register');
Route::Post('Pharmacist-register', 'createPharmacistAccount')->name('Pharmacist-register');
Route::Post('login', 'login')->name('login');
Route::Post('logout', 'logout')->middleware(['auth:api', 'check:api'])->name('logout');
});
Route::middleware(['auth:api'])->group(function () {
Route::middleware(['check:api'])->group(function () {

Route::controller(UserController::class)->group(function () {
Route::get('getUsers','getUsers')->name('getUsers');
Route::get('getUserInfo' ,  'getUserInfo')->name('getUserInfo');
Route::Post('addToFav/{medicine_id}','addToFav')->name('addToFav');
Route::get('getFavs','getFavs')->name('getFavs');
});
Route::controller(MedicineController::class)->group(function () {
Route::Post('createMedicines', 'createMedicines')->name('createMedicines');
Route::get('getMedicines', 'getMedicines')->name('getMedicines');
Route::get('getMyMedicines', 'getMyMedicines')->name('getMyMedicines');
Route::get('getMedicinesOwner/{userId}', 'getMedicinesOwner')->name('getMedicinesOwner');
Route::get('getMedicineId/{MedicinetId}', 'getMedicineId')->name('getMedicineId');
Route::Post('search', 'search')->name('search');
Route::Post('phSearch', 'phSearch')->name('phSearch');
});
Route::controller(CatController::class)->group(function () {
Route::get('getCatMedicines/{catId}', 'getCatMedicines')->name('getCatMedicines');
Route::get('getCategories', 'getCategories')->name('getCategories');
Route::get('getCatOwner/{catId}/{userId}', 'getCatOwner')->name('getCatOwner');
});
Route::controller(OrderController::class)->group(function () {
Route::Post('createOrder/{fromId}', 'createOrder')->name('createOrder');
Route::get('getUserOrders', 'getUserOrders')->name('getUserOrders');
Route::get('getOrders', 'getOrders')->name('getOrders');
Route::get('getSingleOrder/{orderId}', 'getSingleOrder')->name('getSingleOrder');
Route::PUT('updateStatus/{orderID}', 'updateStatus')->name('updateStatus');
Route::PUT('updatePaymentStatus/{orderID}', 'updatePaymentStatus')->name('updatePaymentStatus');
Route::get('getMedicineSalesReport', 'getMedicineSalesReport')->name('getMedicineSalesReport');
});
});
});

