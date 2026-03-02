<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DriveController;
 
Route::get('/', [DriveController::class, 'index'])->name('upload.index');
Route::post('/login', [DriveController::class, 'login'])->name('login');
Route::post('/logout', [DriveController::class, 'logout'])->name('logout');
 
Route::middleware([])->group(function () {
    Route::get('/dashboard', [DriveController::class, 'dashboard'])->name('dashboard');
    Route::post('/folders', [DriveController::class, 'createFolder'])->name('folders.create');
    Route::get('/upload', [DriveController::class, 'uploadForm'])->name('upload.form');
    Route::post('/upload', [DriveController::class, 'store'])->name('upload.store');
    Route::get('/gallery', [DriveController::class, 'gallery'])->name('gallery.index');
    Route::get('/download/{id}', [DriveController::class, 'download'])->name('file.download');
});
