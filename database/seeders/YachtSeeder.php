<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YachtSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('yachts')->insert([
            [
                'id' => 1, 'name' => 'Nordhavn 42 - "Марія"', 'year' => 2024, 'status' => 'available', 
                'price_rent' => 1200.00, 'price_buy' => 450000.00, 'last_maintenance' => '2026-07-17', 
                'type_oper' => 'rent', 'type_id' => 1, 'registration_date' => '2026-07-17', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-17 15:26:15', 'updated_at' => '2026-07-17 15:26:23'
            ],
            [
                'id' => 2, 'name' => 'Nordhavn 52 - "Вікторія"', 'year' => 2025, 'status' => 'available', 
                'price_rent' => 1950.00, 'price_buy' => 650000.00, 'last_maintenance' => '2026-07-17', 
                'type_oper' => 'rent', 'type_id' => 2, 'registration_date' => '2026-07-17', 'is_active' => 1, 
                'comment' => 'Покращена комплектація, Шкіряний салон', 'created_at' => '2026-07-17 15:26:14', 'updated_at' => '2026-07-17 15:26:24'
            ],
            [
                'id' => 3, 'name' => 'Nordhavn 42', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 1200.00, 'price_buy' => 450000.00, 'last_maintenance' => '2026-07-17', 
                'type_oper' => 'buy', 'type_id' => 1, 'registration_date' => '2026-07-17', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-17 15:24:18', 'updated_at' => '2026-07-22 14:00:07'
            ],
            [
                'id' => 4, 'name' => 'Nordhavn 52', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 1800.00, 'price_buy' => 650000.00, 'last_maintenance' => '2026-07-17', 
                'type_oper' => 'buy', 'type_id' => 2, 'registration_date' => '2026-07-17', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-17 15:25:52', 'updated_at' => '2026-07-17 15:26:25'
            ],
            [
                'id' => 5, 'name' => 'Hallberg-Rassy 370', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 1200.00, 'price_buy' => 480000.00, 'last_maintenance' => '2026-07-23', 
                'type_oper' => 'buy', 'type_id' => 3, 'registration_date' => '2026-07-23', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-23 09:03:03', 'updated_at' => '2026-07-23 09:03:05'
            ],
            [
                'id' => 6, 'name' => 'Hallberg-Rassy 370 - "G-Start"', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 1650.00, 'price_buy' => 480000.00, 'last_maintenance' => '2026-07-23', 
                'type_oper' => 'rent', 'type_id' => 3, 'registration_date' => '2026-07-23', 'is_active' => 1, 
                'comment' => 'Покращена комплектація, Салон із водонепроникної тканини, Супутниковий зв\'язок', 'created_at' => '2026-07-23 09:14:32', 'updated_at' => '2026-07-23 09:14:33'
            ],
            [
                'id' => 7, 'name' => 'Beneteau First 30', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 950.00, 'price_buy' => 195000.00, 'last_maintenance' => '2026-07-23', 
                'type_oper' => 'buy', 'type_id' => 4, 'registration_date' => '2026-07-23', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-23 09:32:18', 'updated_at' => '2026-07-23 09:32:19'
            ],
            [
                'id' => 8, 'name' => 'Beneteau First 30 - "Wind Runner"', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 950.00, 'price_buy' => 195000.00, 'last_maintenance' => '2026-07-23', 
                'type_oper' => 'rent', 'type_id' => 4, 'registration_date' => '2026-07-23', 'is_active' => 1, 
                'comment' => 'Покращена комплектація, Спортивні вітрила, Карбоновий штурвал', 'created_at' => '2026-07-23 09:35:58', 'updated_at' => '2026-07-23 09:35:59'
            ],
            [
                'id' => 9, 'name' => 'Beneteau First 30 - "Sea Breeze"', 'year' => 2026, 'status' => 'available', 
                'price_rent' => 850.00, 'price_buy' => 195000.00, 'last_maintenance' => '2026-07-23', 
                'type_oper' => 'rent', 'type_id' => 4, 'registration_date' => '2026-07-23', 'is_active' => 1, 
                'comment' => 'Стандартна комплектація', 'created_at' => '2026-07-23 09:40:53', 'updated_at' => '2026-07-23 09:40:54'
            ],
        ]);
    }
}