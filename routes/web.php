<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/', [BookController::class, 'index'])->name('book.index');
Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show')->whereNumber('book');
Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('lang', $locale);
    return back();
})->name('lang');

Route::middleware('auth')->group(function () {

    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::name('order.')->prefix('/order')->group(function () {
        Route::post('create/{book}', [OrderController::class, 'create'])->name('create');
        Route::delete('delete/{book}', [OrderController::class, 'delete'])->name('delete');
        Route::post('reverse/{book}', [OrderController::class, 'reverse'])->name('reverse');
        Route::put('confirm/{order}', [OrderController::class, 'confirm'])->name('confirm');
        Route::put('accept/{order}', [OrderController::class, 'accept'])->name('accept');
        Route::put('refuse/{order}', [OrderController::class, 'refuse'])->name('refuse');
    });

    Route::middleware('admin')->group(function () {
        Route::name('book.')->prefix('/book')->group(function () {
            Route::get('create', [BookController::class, 'create'])->name('create');
            Route::post('store', [BookController::class, 'store'])->name('store');
        });

        Route::name('admin.')->prefix('/admin')->group(function () {
            Route::get('', [AdminController::class, 'showPanel'])->name('panel');
        });
    });
});
