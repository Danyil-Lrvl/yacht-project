<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YachtPhotoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('yacht_photos')->insert([
            ['id' => 1, 'type_id' => 1, 'image_path' => 'KL1.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'type_id' => 1, 'image_path' => 'KL2.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'type_id' => 1, 'image_path' => 'KL3.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'type_id' => 1, 'image_path' => 'KL4.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'type_id' => 2, 'image_path' => 'KLL1.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'type_id' => 2, 'image_path' => 'KLL2.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 7, 'type_id' => 2, 'image_path' => 'KLL3.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 8, 'type_id' => 2, 'image_path' => 'KLL4.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 9, 'type_id' => 3, 'image_path' => 'Hal1.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 10, 'type_id' => 3, 'image_path' => 'Hal2.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 11, 'type_id' => 3, 'image_path' => 'Hal3.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 12, 'type_id' => 3, 'image_path' => 'Hal4.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 13, 'type_id' => 4, 'image_path' => 'Ben1.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 14, 'type_id' => 4, 'image_path' => 'Ben2.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 15, 'type_id' => 4, 'image_path' => 'Ben3.jpg', 'created_at' => null, 'updated_at' => null],
            ['id' => 16, 'type_id' => 4, 'image_path' => 'Ben4.jpg', 'created_at' => null, 'updated_at' => null],
        ]);
    }
}