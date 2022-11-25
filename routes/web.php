<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\ReturnItemController;
use App\Models\Inventory;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
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
})->name('tracking');

Route::post('requisition/store', [HomeController::class, 'store'])->name('store-requisition');

Route::get('tracking/status', [HomeController::class, 'trackStatus']);

Route::group(['prefix' => 'admin', 'middleware' => ['is_admin']], function(){
    Route::get('home', [AdminController::class, 'index'])->name('admin.home');
    // inventories
    Route::get('inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::post('inventory/store', [InventoryController::class, 'store'])->name('admin.store-inventory');
    Route::delete('inventory/destroy', [InventoryController::class, 'destroy'])->name('admin.destroy-inventory');

    // categories
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('category/store', [CategoryController::class, 'store'])->name('admin.store-category');
    Route::delete('category/destroy', [CategoryController::class, 'destroy'])->name('admin.destroy-category');

    // requisitons
    Route::get('requisition', [RequisitionController::class, 'index'])->name('admin.requisition');
    Route::post('requisition/update', [RequisitionController::class, 'update'])->name('admin.update-requisition');
    Route::delete('requisition/destroy', [RequisitionController::class, 'destroy']);
    Route::get('requisition/status/{id}', [RequisitionController::class, 'viewStatus']);
    Route::post('requisition/status/update', [RequisitionController::class, 'update']);

    Route::get('/accounts', [AccountController::class, 'index'])->name('admin.accounts');
    Route::post('account/store', [AccountController::class, 'store'])->name('admin.store-account');
    Route::delete('account/destroy', [AccountController::class, 'destroy']);

    // store return items
    Route::post('reports/return-items', [ReturnItemController::class, 'store'])->name('return.store-items');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/password/update', [AdminController::class, 'passwordUpdate'])->name('password.update');

    // return Items
    Route::get('reports/return-items', [ReturnItemController::class, 'index'])->name('return.items');
});

Route::group(['prefix' => 'vp-admin', 'middleware' => ['is_vp']], function(){
    Route::get('/home', [AdminController::class, 'vpIndex'])->name('vp.home');
    // inventories
    Route::get('inventory', [InventoryController::class, 'vpIndex'])->name('vp.inventory');
    // requisitons
    Route::get('requisition', [RequisitionController::class, 'vpRequisitionIndex'])->name('vp.requisition');
    Route::get('requisition/status', [RequisitionController::class, 'viewStatus']);
    Route::post('requisition/update', [RequisitionController::class, 'vpUpdate']);
});
Route::group(['prefix' => 'president', 'middleware' => ['is_vp']], function(){
    Route::get('/home', [AdminController::class, 'presidentIndex'])->name('president.home');
    // inventories
    Route::get('inventory', [InventoryController::class, 'presidentIndex'])->name('president.inventory');
    // requisitons
    Route::get('requisition', [RequisitionController::class, 'presidentRequisitionIndex'])->name('president.requisition');
    Route::get('requisition/status', [RequisitionController::class, 'viewStatus']);
    Route::post('requisition/update', [RequisitionController::class, 'presidentUpdate']);
});

Route::get('mail', function(){
    $requisitions = DB::table('requisitions as r')
                        ->leftJoin('inventories as i', 'r.inventory_id', 'i.id')
                        ->select('r.*', 'i.item_name', 'i.quantity_type')
                        ->get();
    return new \App\Mail\RequisitionMail($requisitions);
});


Auth::routes([
    'register' => false,
    'reset' => false, 
    'verify' => false, 
]);