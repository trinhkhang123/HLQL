<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\ProductController;
 
Route::get('/', function () {
    return view('welcome');
});
 
Route::controller(AuthController::class)->group(function () {
    Route::get('test','test')->name('test');
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
  
Route::middleware('auth')->group(function () {
    Route::controller(TraineeController::class)->group(function () {
        Route::post('thongkedvv','thongkedvv')->name('thongkedvv');
        Route::post('getnoidung','getnoidung')->name('getnoidung');
        Route::get('thongkedonvi','thongkedonvi')->name('thongkedonvi');
        Route::get('thongkedonvi/{loai}','thongkedv')->name('thongkedv');
        Route::get('thuchien','thuchien') -> name('thuchien');
        Route::get('dashboard','dashboard') -> name('dashboard');
        Route::get('cacula','cacu')->name('products.cacu');
        Route::get('viewTKB','viewTKB')->name('products.viewTKB');
        Route::post('addAtt','addAtt')->name('products.addAtt');
        Route::get('equipment','equipment')->name('product.equipment');
        Route::delete('equipment/destroy/{id}', 'destroyEQ')->name('products.destroyEQ');
        Route::get('equipment/edit/{id}', 'edit')->name('products.editEQ');  
        Route::put('equipment/edit/{id}', 'update')->name('products.updateEQ'); 
        Route::get('equipment/add', 'addTB')->name('products.addTB');
        Route::post('equipment/add', 'addEQ')->name('products.addEQ'); 
        Route::delete('unit/destroy/{id}', 'unitEQ')->name('products.destroyUN');
        Route::get('unit/add', 'addUNI')->name('products.addUNI');
        Route::post('unit/add', 'addUN')->name('products.addUN'); 
        Route::get('unit','unit')->name('product.unit'); 
        Route::get('tao','tao')->name('tao'); 
        route::get('thuchien/{loai}','thuchient')->name('thuchient');
        route::post('thuchien','thuchienthem') ->name('thuchienthem');
        Route::post('deleteTH','deleteTH')->name('deleteTH');
        Route::post('addTH','addTH')->name('addTH');
    });
    Route::controller(TraineeController::class)->group(function () {
        Route::get('dashboard/{id}/{idd}','dashboardCh') -> name('dashboardCh');
        });

    Route::controller(TraineeController::class)->prefix('profile')->group(function () {
        Route::put('', 'update')->name('profile.update');

    });

    Route::controller(TraineeController::class)->prefix('products')->group(function () {
        Route::post('registerHV', 'registerHV')->name('register.HV');
        Route::post('/updateAtt', 'updateAtt')->name('update.att');
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
        Route::delete('destroyUN/{id}', 'destroyUN')->name('products.destroy');
    });
 
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
});