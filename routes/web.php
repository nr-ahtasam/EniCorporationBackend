<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NavbarController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';

Route::resource('admin/dashboard', AdminController::class)->only(['index']);

Route::get('admin/navbar', [NavbarController::class, 'form'])->name('navbar.form');
Route::post('admin/navbar', [NavbarController::class, 'store'])->name('navbar.form.submit');
Route::get('admin/navbar/{navbar}/edit', [NavbarController::class, 'edit'])->name('navbar.form.edit');
Route::put('admin/navbar/{navbar}', [NavbarController::class, 'update'])->name('navbar.form.update');
Route::delete('admin/navbar/{navbar}', [NavbarController::class, 'destroy'])->name('navbar.form.delete');
Route::patch('admin/navbar/{navbar}/active', [NavbarController::class, 'setActive'])->name('navbar.form.active');

Route::get('/about', [FrontendController::class, 'about']);
