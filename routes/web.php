<?php

use App\Http\Controllers\Admin\Ajax\DeleteImageController;
use App\Http\Controllers\Admin\Ajax\GenerateSkuController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\HomeController;
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

Route::get('/', HomeController::class)->name('home');

Route::resource('categories', CategoryController::class)
    ->only(['index', 'show'])
    ->scoped(['category' => 'slug']);;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('admin.')->prefix('admin')->middleware(['auth', 'role:admin|moderator'])->group(function() {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('products', ProductsController::class)->except(['show']);
    Route::resource('categories', CategoriesController::class)->except(['show']);

    Route::name('ajax.')->middleware('auth')->prefix('ajax')->group(function() {
            Route::delete('images/{image}', DeleteImageController::class)->name('images.delete');
            Route::get('sku/generate', GenerateSkuController::class)->name('sku.generate');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
