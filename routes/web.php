<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\TovarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/delivery', function () {
    return view('pages.delivery');
})->name('delivery');
Route::get('/about', function () {
    return view('pages.about');
})->name('about');
Route::get('/orderuniqe', function () {
    return view('pages.orderuniqe');
})->name('orderuniqe');

Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('showLogin');
    Route::get('/register', 'showRegister')->name('showRegister');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/profile/{id}', 'profile')->name('profile')->middleware('auth');

});
Route::controller(TovarController::class)->group(function () {
    Route::get('/catalog', 'catalog')->name('catalog');
    Route::get('/admin', 'admin')->name('admin')->middleware('admin');

    Route::get('/tovar/delete/{id}', 'showDeleteTovar')->name('showDeleteTovar')->middleware('admin');
    Route::post('/tovar/delete/{id}', 'deleteTovar')->name('deleteTovar')->middleware('admin');

    Route::get('/tovar/{id}', 'showTovar')->name('tovar');

    Route::get('/create/tovar', 'showCreateTovar')->name('createTovar')->middleware('admin');
    Route::get('/create/category', 'showCreateCategory')->name('showcreateCategory')->middleware('admin');
    Route::post('/create/category', 'createCategory')->name('createCategory')->middleware('admin');
    Route::post('/create/tovar', 'createTovar')->name('createTovar')->middleware('admin');

    Route::post('/category/delete/{id}', 'deleteCategory')->name('deleteCategory')->middleware('admin');
    Route::get('/category/delete/{id}', 'showDeleteCategory')->name('showDeleteCategory')->middleware('admin');

    Route::post('/category/update/{id}', 'updateCategory')->name('updateCategory')->middleware('admin');
    Route::get('/category/update/{id}', 'showUpdateCategory')->name('showUpdateCategory')->middleware('admin');

    Route::post('/tovar/update/{id}', 'updateTovar')->name('updateTovar')->middleware('admin');
    Route::get('/tovar/update/{id}', 'showUpdateTovar')->name('showUpdateTovar')->middleware('admin');
});
