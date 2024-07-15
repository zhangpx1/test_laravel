<?php

use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\DevController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('dev-permission')->group(function () {
    Route::get('/dev',[DevController::class,'index'])->name('dev.index');
    Route::post('/dev/executeSql',[DevController::class,'executeSql'])->name('dev.executeSql');
    Route::get('/dev/export', [DevController::class, 'export'])->name('dev.export');
});

require __DIR__.'/auth.php';
