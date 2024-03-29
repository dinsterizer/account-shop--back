<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('health', function () {
    \App\Models\User::first();

    return response()->json(['status' => 'ok']);
});

Route::post('/test-csrf', function () {
    return response(['message' => 'success!!']);
})->name('test.csrf');
Route::post('/test-auth', function (Request $request) {
    return auth()->user();
})->middleware(['auth', 'verified'])->name('test.auth');
