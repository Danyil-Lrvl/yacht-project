<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentBuySeeder extends Seeder
{
    public function run(): void
    {
        // Продажі
        DB::table('prodazha_yachts')->insert([
            [
                'id' => 1, 'yacht_id' => 3, 'client_id' => 3, 'sale_date' => null, 
                'amount' => 450000.00, 'status' => 'заявка', 
                'created_at' => '2026-07-22 14:00:07', 'updated_at' => '2026-07-22 14:00:07'
            ],
        ]);

        // Оренди
        DB::table('rent_yachts')->insert([
            [
                'id' => 2, 'yacht_id' => 1, 'client_id' => 1, 'start_date' => '2026-07-21', 
                'end_date' => '2026-07-27', 'operation_date' => '2026-07-20 11:42:29', 
                'amount' => 7200.00, 'status' => 'анульовано', 
                'created_at' => '2025-07-20 08:42:29', 'updated_at' => '2026-07-21 09:21:02'
            ],
        ]);
    }
}