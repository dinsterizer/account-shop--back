<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests\Request;
// use Illuminate\Support\Carbon;

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

use App\Models\Role;
use App\Models\Permission;

// \Auth::attempt(['email' => 'dinhdjj@gmail.com', 'password' => '12345678']);
Route::get('test', function (Request $request) {
    dd(\App\Models\Permission::find('update_account_type'));
});

Route::get('login', function () {
    return response()->json([
        'message' => 'Bạn vui lòng đăng nhập để sử dụng chức năng này.'
    ], 401);
})->name('login');

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
 * FEATURE ACCOUNT TYPE
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account-type')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\AccountTypeController::class, 'index'])
        ->name('account-type.index');
    // Store
    Route::post('{game}', [App\Http\Controllers\AccountTypeController::class, 'store'])
        ->middleware(['auth', 'can:create,App\Models\AccountType,game'])
        ->name('account-type.store');
    // Show
    Route::get('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'show'])
        ->name('account-type.show');
    // Update
    Route::put('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'update'])
        ->middleware(['auth', 'can:update,accountType'])
        ->name('account-type.update');
    // Destroy
    // Route::delete('{accountType}', [App\Http\Controllers\AccountTypeController::class, 'destroy'])
    //     ->middleware('can:delete,accountType')
    //     ->name('account-type.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT INFO
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account-info')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\AccountInfoController::class, 'index'])
        ->name('account-info.index');
    // Store
    Route::post('{accountType}', [App\Http\Controllers\AccountInfoController::class, 'store'])
        ->middleware(['auth', 'can:create,App\Models\AccountInfo,accountType'])
        ->name('account-info.store');
    // Show
    Route::get('{accountInfo}', [App\Http\Controllers\AccountInfoController::class, 'show'])
        ->name('account-info.show');
    // Update
    Route::put('{accountInfo}', [App\Http\Controllers\AccountInfoController::class, 'update'])
        ->middleware(['auth', 'can:update,accountInfo'])
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
        ->middleware(['auth', 'can:create,App\Models\AccountAction,accountType'])
        ->name('account-action.store');
    // Show
    Route::get('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'show'])
        ->name('account-action.show');
    // Update
    Route::put('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'update'])
        ->middleware(['auth', 'can:update,accountAction'])
        ->name('account-action.update');
    // Destroy
    Route::delete('{accountAction}', [App\Http\Controllers\AccountActionController::class, 'destroy'])
        ->name('account-action.destroy');
});

/**
 * --------------------------------
 * FEATURE GAME
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('game')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\GameController::class, 'index'])
        ->name('game.index');
    // Store
    Route::post('', [App\Http\Controllers\GameController::class, 'store'])
        ->middleware(['auth', 'can:create,App\Models\Game'])
        ->name('game.store');
    // Show
    Route::get('{game}', [App\Http\Controllers\GameController::class, 'show'])
        ->name('game.show');
    // Update
    Route::put('{game}', [App\Http\Controllers\GameController::class, 'update'])
        ->middleware(['auth', 'can:update,game'])
        ->name('game.update');
    // Destroy
    // Route::delete('{game}', [App\Http\Controllers\GameController::class, 'destroy'])
    //     ->middleware('can:delete,game')
    //     ->name('game.destroy');
});

/**
 * --------------------------------
 * FEATURE ACCOUNT
 * --------------------------------
 * Contain infos of account type.
 */
Route::prefix('account')->group(function () {
    // Index
    Route::get('', [App\Http\Controllers\AccountController::class, 'index'])
        ->name('account.index');
    // Store
    Route::post('{game}/{accountType}', [App\Http\Controllers\AccountController::class, 'store'])
        ->middleware(['auth', 'can:create,App\Models\Account,game,accountType'])
        ->name('account.store');
    // approve
    Route::post('approve/{account}', [App\Http\Controllers\AccountController::class, 'approve'])
        ->name('account.approve');
    // Show
    Route::get('{account}', [App\Http\Controllers\AccountController::class, 'show'])
        ->name('account.show');
    // buy
    Route::post('buy/{account}', [App\Http\Controllers\AccountController::class, 'buy'])
        ->name('account.buy');
    // Update
    Route::put('{account}', [App\Http\Controllers\AccountController::class, 'update'])
        ->middleware(['auth', 'can:update,account'])
        ->name('account.update');
    // Destroy
    Route::delete('{account}', [App\Http\Controllers\AccountController::class, 'destroy'])
        ->name('account.destroy');
});
