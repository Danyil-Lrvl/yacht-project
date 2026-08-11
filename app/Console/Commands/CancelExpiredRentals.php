<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RentYacht;
use Carbon\Carbon;

class CancelExpiredRentals extends Command
{
    protected $signature = 'rentals:cancel-expired';
    protected $description = 'Анулює неоплачені заявки на оренду через 3 дні';

    public function handle()
    {
        // Знаходимо заявки зі статусом "заявка", створені більше ніж 3 дні тому
        $expiredRentals = RentYacht::where('status', 'заявка')
            ->where('created_at', '<', Carbon::now()->subDays(3))
            ->get();

        foreach ($expiredRentals as $rental) {
            $rental->status = 'анульовано';
            $rental->save();
        }

        $this->info('Прострочені заявки успішно анульовано.');
    }
}