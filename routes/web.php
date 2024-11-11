<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

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


Route::middleware(['admin'])->group(function () {
    Route::get('/products', [AdminController::class, 'products']);
    Route::post('/uploadproduct', [AdminController::class, 'uploadproduct']);
    Route::get('/showproducts', [AdminController::class, 'showproducts'])->name('showproducts');
    Route::get('/deleteproduct/{id}', [AdminController::class, 'deleteproduct'])->name('deleteproduct');
    Route::get('/updateproduct/{id}', [AdminController::class, 'updateproduct'])->name('updateproduct');
    Route::post('/updatedproduct/{id}', [AdminController::class, 'updatedproduct'])->name('updatedproduct');
    Route::get('/showorder',[AdminController::class,'showorder'])->name('showorder');
    Route::get('/adminchat',[AdminController::class,'adminchat'])->name('adminchat');
    Route::get('/adminchat/{userId?}', [App\Http\Controllers\AdminController::class, 'adminchat'])->name('adminchat');
});


Route::get('/redirect', [HomeController::class, 'redirect']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class,'search']);
Route::post('/addcart/{id}', [HomeController::class, 'addcart'])->name('addcart');
Route::get('/showcart', [HomeController::class,'showcart']);
Route::get('/updatecartcount', [HomeController::class, 'updatecartcount'])->name('updatecartcount');
Route::get('/delete/{id}', [HomeController::class,'deletecart']);
Route::post('/order', [HomeController::class,'order']);
Route::get('/product/{id}',[HomeController::class,'show'])->name('showproduct');
Route::get('/filter-products', [HomeController::class, 'filterProducts'])->name('filter-products');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::post('/showorder/approve/{id}', [AdminController::class, 'approve'])->name('order.approve');
Route::post('/showorder/disapprove/{id}', [AdminController::class, 'disapprove'])->name('order.disapprove');
Route::delete('/showorder/delete/{id}', [AdminController::class, 'delete'])->name('order.delete');


Route::get('/chat/{userId}', [HomeController::class, 'chat'])->name('chat');
Route::post('/broadcast', 'App\Http\Controllers\PusherController@broadcast');
Route::post('/receive', 'App\Http\Controllers\PusherController@receive');

Broadcast::routes(['middleware' => ['auth']]);


Route::post('/broadcasting/auth', function (Request $request) {
    $user = Auth::user(); // Get the authenticated user

    // Log the authenticated user
    logger('Authenticated user: ', ['user' => $user]);

    // If user is not authenticated, return a 403 Forbidden response
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Log the incoming request for debugging
    logger('Incoming request: ', ['request' => $request->all()]);

    // Authorize the channel
    return Broadcast::auth($request);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

