<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('drive')->group(function () {
    Route::post('/folders', [ApiController::class, 'createFolder']);
    Route::post('/upload', [ApiController::class, 'uploadFile']);
    Route::get('/files/{id}', [ApiController::class, 'getFile']);
    Route::get('/download/{id}', [ApiController::class, 'downloadFile']);
});
