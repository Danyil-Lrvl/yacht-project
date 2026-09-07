<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminRentBuyController;
use App\Http\Controllers\Admin\AdminTypeController;
use App\Http\Controllers\Admin\AdminYachtController;
use App\Http\Controllers\Admin\AdminPhotoController;
use Illuminate\Http\Request;

// 1. Головна
Route::get('/', [HomeController::class, 'home']);

// 2. API-маршрут
Route::get('/yacht/booked-dates/{yacht_id}', [OrderController::class, 'getBookedDates']);

// 3. Адмін-панель (Логін, Вихід та перевірка пароля через модалку)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Маршрут перевірки пароля з AJAX-модалки
Route::post('/admin/check-password', [AdminAuthController::class, 'checkPassword'])->name('admin.check.password');

Route::get('/admin', function () {
    if (session('admin_logged_in')) {
        return redirect()->route('admin.rent');
    }
    return redirect()->route('admin.login.form');
});

// Адмін-панель (Захищено через AdminMiddleware)
Route::middleware(['web', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/rent', [AdminRentBuyController::class, 'rent'])->name('rent');
    Route::get('/buy', [AdminRentBuyController::class, 'buy'])->name('buy');
    Route::get('/types', [AdminTypeController::class, 'types'])->name('types');
    Route::get('/yachts', [AdminYachtController::class, 'yachts'])->name('yachts');
    Route::get('/photos', [AdminPhotoController::class, 'photos'])->name('photos');

    // Дії в адмін-панелі (збереження, оновлення, видалення)
    Route::post('/type/store', [AdminTypeController::class, 'storeType'])->name('type.store');
    Route::put('/type/update/{id}', [AdminTypeController::class, 'updateType'])->name('type.update');

    Route::post('/yacht/store', [AdminYachtController::class, 'storeYacht'])->name('yacht.store');
    Route::put('/yacht/update/{id}', [AdminYachtController::class, 'updateYacht'])->name('yacht.update');

    Route::post('/photos/store', [AdminPhotoController::class, 'storePhotos'])->name('photos.store');
    Route::put('/photos/update/{id}', [AdminPhotoController::class, 'updatePhoto'])->name('photos.update');
    Route::delete('/photos/destroy/{id}', [AdminPhotoController::class, 'destroyPhoto'])->name('photos.destroy');

    Route::post('/order/status', [AdminRentBuyController::class, 'updateOrderStatus'])->name('order.status');
});

// --- КЛІЄНТСЬКА АВТОРИЗАЦІЯ ТА ПРОФІЛЬ ---
Route::get('/client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login.form');
Route::get('/client/register', [ClientAuthController::class, 'showRegisterForm'])->name('client.register.form');

// Додано аліас `client.auth`, який використовується у view (наприклад, у шапці сайту/модалках)
Route::get('/client/auth', function () {
    return redirect()->route('client.login.form');
})->name('client.auth');

Route::post('/client/register', [ClientAuthController::class, 'registerClient'])->name('client.register');
Route::post('/client/login', [ClientAuthController::class, 'loginClient'])->name('client.login');
Route::post('/client/logout', [ClientAuthController::class, 'logoutClient'])->name('client.logout');

Route::get('/login', function () {
    return redirect()->route('client.login.form');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('client.register.form');
})->name('register');

Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/data', [ClientAuthController::class, 'showClientData'])->name('client.data');
    Route::post('/client/data/update', [ClientAuthController::class, 'updateClientData'])->name('client.data.update');
    Route::get('/client/actions', [ClientAuthController::class, 'showClientActions'])->name('client.actions');
});
// ----------------------------------------

// 4. СПЕЦИФІЧНІ СТОРІНКИ ФОРМ (Оренда та Купівля конкретної яхти)
Route::get('/yacht/rent/{id}', [OrderController::class, 'showRentForm'])->name('yacht.rent');
Route::get('/yacht/buy/{id}', [OrderController::class, 'showBuyForm'])->name('yacht.buy');

// 5. Обробка POST-запитів форм
Route::post('/yacht/rent/submit', [OrderController::class, 'storeRent'])->name('yacht.rent.submit');
Route::post('/yacht/buy/submit', [OrderController::class, 'storeBuy'])->name('yacht.buy.submit');

// 6. Список яхт за типом
Route::get('/yachts/{type}', [HomeController::class, 'index']);

// 7. Детальний перегляд (має стояти нижче специфічних роутів `/yacht/rent/...`, щоб Laravel не плутав `{id}` із документами/рентою)
Route::get('/yacht/{id}/{type?}', [HomeController::class, 'show'])->name('yacht.show');