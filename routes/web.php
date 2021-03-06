<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', "App\Http\Controllers\AdminController@admin")->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');
    Route::post('/addCategory', [AdminController::class, 'addCategory'])->name('addCategory');
    Route::post('/createProduct', [AdminController::class, 'createProduct'])->name('createProduct');
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    

    Route::prefix('roles')->group(function() {
        Route::post('/add', [AdminController::class, 'addRole'])->name('addRole');
        Route::post('/addRoleToUser', [AdminController::class, 'addRoleToUser'])->name('addRoleToUser');
        
    });
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
});

Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/category/{category}/getProducts', [HomeController::class, 'getProducts']);
Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');

Route::post('/ExportProducts', [AdminController::class, 'ExportProducts'])->name('ExportProducts'); 
Route::post('/ImportProducts', [AdminController::class, 'ImportProducts'])->name('ImportProducts');
Route::post('/ExportCategories', [AdminController::class, 'ExportCategories'])->name('ExportCategories');
Route::post('/ImportCategories', [AdminController::class, 'ImportCategories'])->name('ImportCategories');


Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
Route::post('/repeatOrder', [CartController::class, 'repeatOrder'])->name('repeatOrder');
 
Auth::routes();