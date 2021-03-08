<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

\Auth::attempt(['email' => 'dinhdjj@gmail.com', 'password' => '12345678']);
Route::patch('test', function (Request $request) {
    return dd($request->testFile);
});

/**
 * --------------------------------
 * FEATURE RULE
 * --------------------------------
 * Include infos to make rules to validate in font-end and back-end.
 */
Route::prefix('rule')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\RuleController::class, 'index'])
        ->name('rule.index');
    // Store
    Route::post('', [App\Http\Controllers\RuleController::class, 'store'])
        ->name('rule.store');
    // Show
    Route::get('{rule}', [App\Http\Controllers\RuleController::class, 'show'])
        ->name('rule.show');
    // Update
    Route::put('{rule}', [App\Http\Controllers\RuleController::class, 'update'])
        ->name('rule.update');
    // Destroy
    Route::delete('{rule}', [App\Http\Controllers\RuleController::class, 'destroy'])
        ->name('rule.destroy');
});


/**
 * --------------------------------
 * FEATURE PUBLISHER
 * --------------------------------
 * Contain infos of publisher.
 */
Route::prefix('publisher')->group(function () {
    // Index
    Route::get('manage', [App\Http\Controllers\PublisherController::class, 'manage'])
        ->name('publisher.manage');
    // Store
    Route::post('', [App\Http\Controllers\PublisherController::class, 'store'])
        ->name('publisher.store');
    // Show
    Route::get('{publisher}', [App\Http\Controllers\PublisherController::class, 'show'])
        ->name('publisher.show');
    // Update
    Route::put('{publisher}', [App\Http\Controllers\PublisherController::class, 'update'])
        ->name('publisher.update');
    // Destroy
    Route::delete('{publisher}', [App\Http\Controllers\PublisherController::class, 'destroy'])
        ->name('publisher.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT TYPE
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account-type')->group(function () {
    // Index
    Route::get('manage', [App\Http\Controllers\AccountTypeController::class, 'manage'])
        ->name('account-type.manage');
    // Store
    Route::post('{publisher}', [App\Http\Controllers\AccountTypeController::class, 'store'])
        ->name('account-type.store');
    // Show
    Route::get('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'show'])
        ->name('account-type.show');
    // Update
    Route::put('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'update'])
        ->name('account-type.update');
    // Destroy
    Route::delete('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'destroy'])
        ->name('account-type.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT INFO
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account-info')->group(function () {
    // Index
    Route::get('manage', [App\Http\Controllers\AccountInfoController::class, 'manage'])
        ->name('account-info.manage');
    // Store
    Route::post('{accountType}', [App\Http\Controllers\AccountInfoController::class, 'store'])
        ->name('account-info.store');
    // Show
    Route::get('{accountInfo}', [App\Http\Controllers\AccountInfoController::class, 'show'])
        ->name('account-info.show');
    // Update
    Route::put('{accountInfo}', [App\Http\Controllers\AccountInfoController::class, 'update'])
        ->name('account-info.update');
    // Destroy
    Route::delete('{accountInfo}', [App\Http\Controllers\AccountInfoController::class, 'destroy'])
        ->name('account-info.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT ACTION
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account-action')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\AccountActionController::class, 'index'])
        ->name('account-action.index');
    // Store
    Route::post('{accountType}', [App\Http\Controllers\AccountActionController::class, 'store'])
        ->name('account-action.store');
    // Show
    Route::get('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'show'])
        ->name('account-action.show');
    // Update
    Route::put('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'update'])
        ->name('account-action.update');
    // Destroy
    Route::delete('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'destroy'])
        ->name('account-action.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT ACTION
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('game')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\GameController::class, 'index'])
        ->name('game.index');
    // Store
    Route::post('', [App\Http\Controllers\GameController::class, 'store'])
        ->name('game.store');
    // Show
    Route::get('{game}', [App\Http\Controllers\GameController::class, 'show'])
        ->name('game.show');
    // Update
    Route::put('{game}', [App\Http\Controllers\GameController::class, 'update'])
        ->name('game.update');
    // Destroy
    Route::delete('{game}', [App\Http\Controllers\GameController::class, 'destroy'])
        ->name('game.destroy');
});
