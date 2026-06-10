<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

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
Route::post('/ajax/category/deleteData',[CategoryController::class,'deleteData'])
        ->name('categories.deleteData');
Route::post('/ajax/categories/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])
    ->name('categories.saveDataUpdate');
Route::post('/ajax/categories/getEditFormB',[CategoryController::class,'getEditFormB'])
            ->name('categories.getEditFormB');
Route::post('/ajax/categories/getEditForm',[CategoryController::class,'getEditForm'])->name('categories.getEditForm');

Route::post('/ajax/doctors/getEditFormB',[DoctorController::class,'getEditFormB'])
            ->name('doctors.getEditFormB');
Route::post('/ajax/doctors/saveDataUpdate',[DoctorController::class,'saveDataUpdate'])
            ->name('doctors.saveDataUpdate');
Route::post('/ajax/doctors/deleteData',[DoctorController::class,'deleteData'])
            ->name('doctors.deleteData');

Route::post('/ajax/articles/getEditFormB',[ArticleController::class,'getEditFormB'])
            ->name('articles.getEditFormB');
Route::post('/ajax/articles/saveDataUpdate',[ArticleController::class,'saveDataUpdate'])
            ->name('articles.saveDataUpdate');
Route::post('/ajax/articles/deleteData',[ArticleController::class,'deleteData'])
            ->name('articles.deleteData');

Route::post('/ajax/services/getEditFormB',[ServiceController::class,'getEditFormB'])
            ->name('services.getEditFormB');
Route::post('/ajax/services/saveDataUpdate',[ServiceController::class,'saveDataUpdate'])
            ->name('services.saveDataUpdate');
Route::post('/ajax/services/deleteData',[ServiceController::class,'deleteData'])
            ->name('services.deleteData');

Route::post('/ajax/transactions/getEditFormB',[TransactionController::class,'getEditFormB'])
            ->name('transactions.getEditFormB');
Route::post('/ajax/transactions/saveDataUpdate',[TransactionController::class,'saveDataUpdate'])
            ->name('transactions.saveDataUpdate');
Route::post('/ajax/transactions/deleteData',[TransactionController::class,'deleteData'])
            ->name('transactions.deleteData');

Route::resource('doctors', DoctorController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('articles', ArticleController::class);
Route::resource('services', ServiceController::class);
Route::get('/categories/showExpensiveService', [CategoryController::class, 'showExpensiveService']);
Route::resource('categories', CategoryController::class);
Route::get('/', function () {
    //return view('welcome');
    return view('layouts/adminlte4');
});
Route::get('/welcome', function () {
    //return ('Selamat Datang di Portal Kesehatan');
    return view('welcome');
})->name('welcome');
Route::get('/menu', function () {
    //return ('Pilih Konsultasi Online atau Buat Janji Temu');
    return view('menu');
})->name('menu');
Route::get('/menu/{layanan}', function ($layanan) {
    if ($layanan == "Konsultasi") {
        //return "Daftar layanan Konsultasi Online";
        return view('Konsultasi');
    } 
     elseif ($layanan == "Janji") {
        //return "Daftar layanan Janji Temu Dokter";
        return view('Janji');
    } 
     else {
        return ('Layanan tidak ditemukan');
    }
});
Route::get('/admin/{menu}', function ($menu) {
    if ($menu == "categories") {
//        return "Portal Manajemen: Daftar Kategori Layanan";
        return view('admin.categories');
    } elseif ($menu == "order") {
        //return "Portal Manajemen: Daftar Konsultasi dan Janji Temu";
        return view('admin.order');
    } elseif ($menu == "members") {
        //return "Portal Manajemen: Daftar Pasien";
        return view('admin.members');
    } else {
        return "Menu admin tidak ditemukan";
    }
});
Route::post("/category/showInfo",[CategoryController::class, 'showInfo'])->name("category.showInfo");
Route::post("/category/showListServices",
            [CategoryController::class, 'showListServices'])
        ->name("category.showListServices");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
