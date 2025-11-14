<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SessionsController;
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

Route::post('file', [ImageUploadController::class, 'upload'])->name('file.upload');
Route::get('/selection-session', [SessionsController::class, 'selectionSession']);
Route::get('/selection-session-remove', [SessionsController::class, 'selectionSessionRemoved']);
