<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YachtController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

// 1. Головна
Route::get('/', [YachtController::class, 'home']);

// 2. API-маршрут
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

// --- КЛІЄНТСЬКА АВТОРИЗАЦІЯ ТА ПРОФІЛЬ ---
Route::get('/client/login', [YachtController::class, 'showLoginForm'])->name('client.login.form');
Route::get('/client/register', [YachtController::class, 'showRegisterForm'])->name('client.register.form');

Route::post('/client/register', [YachtController::class, 'registerClient'])->name('client.register');
Route::post('/client/login', [YachtController::class, 'loginClient'])->name('client.login');
Route::post('/client/logout', [YachtController::class, 'logoutClient'])->name('client.logout');

Route::get('/login', function () {
    return redirect()->route('client.login.form');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('client.register.form');
})->name('register');

Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/data', [YachtController::class, 'showClientData'])->name('client.data');
    Route::post('/client/data/update', [YachtController::class, 'updateClientData'])->name('client.data.update');
    Route::get('/client/actions', [YachtController::class, 'showClientActions'])->name('client.actions');
});
// ----------------------------------------

// 4. СПЕЦИФІЧНІ СТОРІНКИ
Route::get('/yacht/rent/{id}', [YachtController::class, 'showRentForm'])->name('yacht.rent');
Route::get('/yacht/buy/{id}', [YachtController::class, 'showBuyForm'])->name('yacht.buy');

// 5. Обробка POST-запитів
Route::post('/yacht/rent/submit', [YachtController::class, 'storeRent'])->name('yacht.rent.submit');
Route::post('/yacht/buy/submit', [YachtController::class, 'storeBuy'])->name('yacht.buy.submit');

// 6. Список яхт за типом
Route::get('/yachts/{type}', [YachtController::class, 'index']);

// 7. Детальний перегляд
Route::get('/yacht/{id}/{type?}', [YachtController::class, 'show']);