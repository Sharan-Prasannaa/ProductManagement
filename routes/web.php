<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard',[DashboardController::class,'index']
            )->middleware(['auth','verified'])->name('dashboard');

Route::get('/categories',[CategoryController::class,'index'])->name('categories');
Route::get('/categories/add',[CategoryController::class,'create'])->name('categories.add');
Route::post('/categories/check-name',[CategoryController::class,'checkName'])->name('categories.check-name');
Route::post('/categories/add',[CategoryController::class,'store'])->name('categories.add');
Route::get('/categories/{id}/edit',[CategoryController::class,'edit'])->name('categories.edit');
Route::put('/categories/{id}/edit',[CategoryController::class,'update'])->name('categories.edit');
Route::get('/categories/{id}/delete',[CategoryController::class,'destroy'])->name('categories.destroy');

Route::get('/suppliers',[SupplierController::class,'index'])->name('suppliers');
Route::get('/suppliers/create',[SupplierController::class,'create'])->name('suppliers.create');
Route::post('/suppliers/check-email', [SupplierController::class, 'checkEmail'])->name('suppliers.check-email');
Route::post('/suppliers/add',[SupplierController::class,'store'])->name('suppliers.add');
Route::get('/suppliers/{id}/edit',[SupplierController::class,'edit'])->name('suppliers.edit');
Route::put('/supplier/{id}/update',[SupplierController::class,'update'])->name('suppliers.update');
Route::get('/suppliers/{id}/delete',[SupplierController::class,'destroy'])->name('suppliers.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::post('/products/create',[ProductController::class,'store'])->name('products.store');
Route::get('/products/{id}/edit',[ProductController::class,'edit'])->name('products.edit');
Route::put('/products{id}/update',[ProductController::class,'update'])->name('products.update');
Route::get('/products/{id}/delete',[ProductController::class,'destroy'])->name('products.destroy');
Route::get('/products/filter',[ProductController::class,'filter'])->name('products.filter');


require __DIR__.'/auth.php';
