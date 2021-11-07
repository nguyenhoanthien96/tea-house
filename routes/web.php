<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiftCodeController;

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

Route::get('/', function () {
    return redirect(route('gift_event.index'));
});


Route::get('/gift-event', [GiftCodeController::class, 'index'])->name('gift_event.index');

Route::get('/employee-gift', [GiftCodeController::class, 'getEmployeeGift'])->name('employee_gift');

Route::get('/gift-code', [GiftCodeController::class, 'getGiftCode'])->name('gift_code');

Route::post('/gift', [GiftCodeController::class, 'getGift'])->name('get_gift');