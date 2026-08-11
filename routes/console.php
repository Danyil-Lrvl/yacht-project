<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // Імпорт для планувальника

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Автоматичне анулювання прострочених заявок на покупку та повернення яхт у каталог через 3 дні
Schedule::command('orders:cancel-expired')->daily();