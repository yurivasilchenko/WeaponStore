<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/redirect', [HomeController::class, 'redirect']);
Route::get('/', [HomeController::class, 'index']);

Route::get('/products', [AdminController::class, 'products']);
Route::post('/uploadproduct', [AdminController::class, 'uploadproduct']);

Route::get('/showproducts', [AdminController::class, 'showproducts']);

/*Route::get('/deleteproduct/{id}', [AdminController::class, 'deleteproduct']);*/
Route::get('/deleteproduct/{id}', [AdminController::class, 'deleteproduct'])->name('deleteproduct');

Route::get('/updateproduct/{id}', [AdminController::class, 'updateproduct'])->name('updateproduct');
Route::post('/updatedproduct/{id}', [AdminController::class, 'updatedproduct'])->name('updatedproduct');

Route::get('/search', [HomeController::class,'search']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
