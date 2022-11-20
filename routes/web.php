<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RequisitionController;
use App\Models\Inventory;
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
    return view('auth.login');
});

Route::get('request-form', [HomeController::class, 'request_form'])->name('request.form');
// tracking
Route::get('tracking', function(){
    return view('tracking');
});

Route::get('tracking/status', [HomeController::class, 'trackStatus']);

Route::group(['prefix' => 'admin'], function(){
    Route::get('home', [AdminController::class, 'index'])->name('admin.home');
    // inventories
    Route::get('inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::post('inventory/store', [InventoryController::class, 'store'])->name('admin.store-inventory');
    Route::delete('inventory/destroy', [InventoryController::class, 'destroy'])->name('admin.destroy-inventory');

    // requisitons
    Route::get('requisition', [RequisitionController::class, 'index'])->name('admin.requisition');
    Route::post('requisition/store', [RequisitionController::class, 'store'])->name('admin.store-requisition');
    Route::post('requisition/update', [RequisitionController::class, 'update'])->name('admin.update-requisition');
});

Auth::routes([
    'register' => false,
    'reset' => false, 
    'verify' => false, 
]);