<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::get('/', [ActivityController::class, 'index'])->name('activity.index');
Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
Route::put('/activity/{id}', [ActivityController::class, 'update'])->name('activity.update');
Route::delete('/activity/{id}', [ActivityController::class, 'delete'])->name('activity.delete');
Route::post('/activity/{id}/toggle', [ActivityController::class, 'Completed'])->name('activity.toggle');