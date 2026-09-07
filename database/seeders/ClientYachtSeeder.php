<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientYachtSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients_yachts')->insert([
            [
                'id' => 1,
                'full_name' => 'Іван Іваненко',
                'document_number' => 'АА 123456',
                'document_issued_by' => 'Шевченківським РВ УМВС',
                'document_date' => '2022-11-24',
                'phone' => '+380 99 123 4567',
                'email' => 'ivan.ivanenko@example.com',
                'password' => '$2y$12$N12345PlaceholderHashForTestingPurposesOnly00000000000000001',
                'address' => 'м. Київ, вул. Хрещатик, 1',
                'tax_id' => '1234567890',
                'created_at' => '2026-07-20 11:42:29',
                'updated_at' => '2026-07-20 11:42:29',
            ],
            [
                'id' => 2,
                'full_name' => 'Шевченко Тарас Григорович',
                'document_number' => 'АА123456',
                'document_issued_by' => 'Шевченківським РВ УМВС',
                'document_date' => '2021-07-22',
                'phone' => '+380951234567',
                'email' => 'test@gmail.com',
                'password' => '$2y$12$M12345PlaceholderHashForTestingPurposesOnly00000000000000002',
                'address' => 'м. Київ, вул. Хрещатик, 1',
                'tax_id' => '1234567890',
                'created_at' => '2026-07-22 16:56:26',
                'updated_at' => '2026-07-22 16:56:26',
            ],
            [
                'id' => 3,
                'full_name' => 'Шевченко Тарас Григорович',
                'document_number' => 'АА123456',
                'document_issued_by' => 'Шевченківським РВ УМВС',
                'document_date' => '2021-07-22',
                'phone' => '+380951234567',
                'email' => 'test2@gmail.com',
                'password' => '$2y$12$M12345PlaceholderHashForTestingPurposesOnly00000000000000002',
                'address' => 'м. Київ, вул. Хрещатик, 1',
                'tax_id' => '1234567890',
                'created_at' => '2026-07-22 17:00:07',
                'updated_at' => '2026-07-22 17:00:07',
            ],
        ]);
    }
}