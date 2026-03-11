<?php

Route::get('/', function () {
   echo "Hello World";
});

use Illuminate\Support\Facades\Route;
use App\http\controllers\Admin\AdminController;
use Inertia\Inertia;
use Laravel\Fortify\Features;




Route::get('/', function () {
    return view('app');
});

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
