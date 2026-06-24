<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TransactionController;

Auth::routes();

/*
|--------------------------------------------------------------------------
| Front End
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontEndController::class, 'home']);
Route::get('/detail/{service}', [FrontEndController::class, 'detail'])
    ->name('detailService');

Route::get('/cart', [FrontEndController::class, 'cart']);

Route::put('/goto-cart/{service}', [FrontEndController::class, 'putCart'])
    ->name('putCart');

Route::delete('/goto-cart/{service}', [FrontEndController::class, 'deleteCart'])->name('deleteCart');

Route::post('/submit', [FrontEndController::class, 'checkout'])
    ->name('checkout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes yang wajib login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Category Ajax
    Route::post('/ajax/category/deleteData', [CategoryController::class, 'deleteData'])
        ->name('categories.deleteData');

    Route::post('/ajax/categories/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])
        ->name('categories.saveDataUpdate');

    Route::post('/ajax/categories/getEditFormB', [CategoryController::class, 'getEditFormB'])
        ->name('categories.getEditFormB');

    Route::post('/ajax/categories/getEditForm', [CategoryController::class, 'getEditForm'])
        ->name('categories.getEditForm');

    Route::post('/category/showInfo', [CategoryController::class, 'showInfo'])
        ->name('category.showInfo');

    Route::post('/category/showListServices', [CategoryController::class, 'showListServices'])
        ->name('category.showListServices');

    Route::get('/categories/showExpensiveService', [CategoryController::class, 'showExpensiveService']);

    Route::resource('categories', CategoryController::class);

    // Service Ajax
    Route::post('/ajax/services/deleteData', [ServiceController::class, 'deleteData'])
        ->name('services.deleteData');

    Route::post('/ajax/services/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])
        ->name('services.saveDataUpdate');

    Route::post('/ajax/services/getEditFormB', [ServiceController::class, 'getEditFormB'])
        ->name('services.getEditFormB');

    Route::post('/ajax/services/getEditForm', [ServiceController::class, 'getEditForm'])
        ->name('services.getEditForm');

    Route::resource('services', ServiceController::class);

    // Doctor Ajax
    Route::post('/ajax/doctors/deleteData', [DoctorController::class, 'deleteData'])
        ->name('doctors.deleteData');

    Route::post('/ajax/doctors/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])
        ->name('doctors.saveDataUpdate');

    Route::post('/ajax/doctors/getEditFormB', [DoctorController::class, 'getEditFormB'])
        ->name('doctors.getEditFormB');

    Route::post('/ajax/doctors/getEditForm', [DoctorController::class, 'getEditForm'])
        ->name('doctors.getEditForm');

    Route::resource('doctors', DoctorController::class);

    // Article Ajax
    Route::post('/ajax/articles/deleteData', [ArticleController::class, 'deleteData'])
        ->name('articles.deleteData');

    Route::post('/ajax/articles/saveDataUpdate', [ArticleController::class, 'saveDataUpdate'])
        ->name('articles.saveDataUpdate');

    Route::post('/ajax/articles/getEditFormB', [ArticleController::class, 'getEditFormB'])
        ->name('articles.getEditFormB');

    Route::post('/ajax/articles/getEditForm', [ArticleController::class, 'getEditForm'])
        ->name('articles.getEditForm');

    Route::resource('articles', ArticleController::class);

    // Transaction Ajax
    Route::post('/ajax/transactions/deleteData', [TransactionController::class, 'deleteData'])
        ->name('transactions.deleteData');

    Route::post('/ajax/transactions/saveDataUpdate', [TransactionController::class, 'saveDataUpdate'])
        ->name('transactions.saveDataUpdate');

    Route::post('/ajax/transactions/getEditFormB', [TransactionController::class, 'getEditFormB'])
        ->name('transactions.getEditFormB');

    Route::post('/ajax/transactions/getEditForm', [TransactionController::class, 'getEditForm'])
        ->name('transactions.getEditForm');

    Route::resource('transactions', TransactionController::class);
});

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu/{layanan?}', function ($layanan = null) {

    if ($layanan == 'Konsultasi') {
        return view('Konsultasi');
    }

    if ($layanan == 'Janji') {
        return view('Janji');
    }

    return view('menu');
})->name('menu');

Route::get('/admin/{menu}', function ($menu) {

    if ($menu == 'categories') {
        return view('admin.categories');
    }

    if ($menu == 'order') {
        return view('admin.order');
    }

    if ($menu == 'members') {
        return view('admin.members');
    }

    return 'Menu admin tidak ditemukan';
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');