<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Оновлення унікальних "плюшок" (описів) українською для кожної яхти

        // Яхти для оренди
        DB::table('yachts')->where('id', 1)->update([
            'comment' => 'Кондиціонер, Супутниковий зв\'язок, Круїзний лайнер'
        ]);
        DB::table('yachts')->where('id', 2)->update([
            'comment' => 'Преміум комфорт, Автопілот, Шкіряний салон'
        ]);
        DB::table('yachts')->where('id', 6)->update([
            'comment' => 'Вітрильна яхта, Повний комплект, Водонепроникний тенти'
        ]);

        // Яхти для покупки
        DB::table('yachts')->where('id', 3)->update([
            'comment' => 'Повна заводська гарантія, Сучасна навігація'
        ]);
        DB::table('yachts')->where('id', 4)->update([
            'comment' => 'Ексклюзивний дизайн інтер\'єру, Додатковий комплект парусів'
        ]);
        DB::table('yachts')->where('id', 5)->update([
            'comment' => 'Пільгове обслуговування в порті, Страховка на рік'
        ]);
    }
}