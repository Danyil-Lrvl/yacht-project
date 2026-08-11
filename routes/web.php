<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YachtController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

// 1. Головна
Route::get('/', [YachtController::class, 'home']);

// 2. API-маршрут (МАЄ БУТИ ВИЩЕ ЗА УНІВЕРСАЛЬНІ)
Route::get('/yacht/booked-dates/{yacht_id}', [YachtController::class, 'getBookedDates']);

// 3. Адмін-панель та перевірка пароля
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/check-password', function (Request $request) {
    if ($request->password === env('ADMIN_PASSWORD')) {
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 401);
});
Route::post('/admin/yacht/store', [AdminController::class, 'storeYacht'])->name('admin.yacht.store');
Route::post('/admin/order/status', [AdminController::class, 'updateOrderStatus'])->name('admin.order.status');

// 4. Специфічні сторінки (оренда/купівля)
Route::get('/yacht/rent/{id}', [YachtController::class, 'showRentForm'])->name('yacht.rent');
Route::get('/yacht/buy/{id}', [YachtController::class, 'showBuyForm'])->name('yacht.buy');

// 5. Обробка POST-запитів
Route::post('/yacht/rent/submit', [YachtController::class, 'storeRent'])->name('yacht.rent.submit');
Route::post('/yacht/buy/submit', [YachtController::class, 'storeBuy'])->name('yacht.buy.submit');

// 6. Список яхт за типом
Route::get('/yachts/{type}', [YachtController::class, 'index']);

// 7. Детальний перегляд (ЗАЛИШАЄМО ОСТАННІМ)
Route::get('/yacht/{id}/{type?}', [YachtController::class, 'show']);