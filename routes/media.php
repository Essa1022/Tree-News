<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
    Route::post('upload/{model_type}/{model_id}', [MediaController::class, 'upload'])->name('upload');
    Route::delete('destroy', [MediaController::class, 'destroy'])->name('destroy');
    Route::post('download/{id}', [MediaController::class, 'download'])->name('download')->withoutMiddleware('auth:sanctum');
});
