<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YachtController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

// 1. Головна
Route::get('/', [YachtController::class, 'home']);

// 2. API-маршрут
Route::get('/yacht/booked-dates/{yacht_id}', [YachtController::class, 'getBookedDates']);

// 3. Адмін-панель (Логін, Вихід)
Route::get('/admin/login', function () {
    return redirect()->route('admin.rent');
})->name('admin.login.form');

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin', function () {
    return redirect()->route('admin.rent');
});

// Адмін-панель (захист через модальне вікно layout.blade.php)
Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/rent', [AdminController::class, 'rent'])->name('rent');
    Route::get('/buy', [AdminController::class, 'buy'])->name('buy');
    Route::get('/types', [AdminController::class, 'types'])->name('types');
    Route::get('/yachts', [AdminController::class, 'yachts'])->name('yachts');
    Route::get('/photos', [AdminController::class, 'photos'])->name('photos');

    // Дії в адмін-панелі (збереження, оновлення, видалення)
    Route::post('/type/store', [AdminController::class, 'storeType'])->name('type.store');
    Route::put('/type/update/{id}', [AdminController::class, 'updateType'])->name('type.update');

    Route::post('/yacht/store', [AdminController::class, 'storeYacht'])->name('yacht.store');
    Route::put('/yacht/update/{id}', [AdminController::class, 'updateYacht'])->name('yacht.update');

    Route::post('/photos/store', [AdminController::class, 'storePhotos'])->name('photos.store');
    Route::put('/photos/update/{id}', [AdminController::class, 'updatePhoto'])->name('photos.update');
    Route::delete('/photos/destroy/{id}', [AdminController::class, 'destroyPhoto'])->name('photos.destroy');

    Route::post('/order/status', [AdminController::class, 'updateOrderStatus'])->name('order.status');
});

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