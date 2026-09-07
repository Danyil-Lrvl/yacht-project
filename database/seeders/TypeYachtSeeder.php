<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeYachtSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('type_yachts')->insert([
            [
                'id_type' => 1,
                'name_type' => 'Nordhavn 42',
                'short_description' => 'Надійна експедиційна яхта для далеких подорожей',
                'full_description' => 'Повний опис яхти Nordhavn 42: ідеальний вибір для тривалих морських переходів.',
                'image_path' => 'nordhavn42.jpg',
                'max_passengers' => 8,
                'length' => '42 ft',
                'width' => '13 ft',
                'cabins' => 2,
                'heads' => 2,
                'engine_power' => '160 hp',
                'engine_model' => 'Lugger L668D',
                'year' => 2024,
                'condition' => 'New',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id_type' => 2,
                'name_type' => 'Nordhavn 52',
                'short_description' => 'Розкішна океанська яхта для тривалих експедицій.',
                'full_description' => 'Nordhavn 52 — це втілення комфорту та надійності. Вона пропонує більше внутрішнього простору та сучасне обладнання для впевненого переходу через океан.',
                'image_path' => 'nordhavn52.jpg',
                'max_passengers' => 8,
                'length' => '52 ft',
                'width' => '16 ft',
                'cabins' => 3,
                'heads' => 2,
                'engine_power' => '240 hp',
                'engine_model' => 'Lugger L1066T',
                'year' => 2026,
                'condition' => 'New',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id_type' => 3,
                'name_type' => 'Hallberg-Rassy 370',
                'short_description' => 'Класична шведська крейсерська яхта для комфортних і безпечних морських подорожей під вітрилами.',
                'full_description' => 'Hallberg-Rassy 370 поєднує в собі видатну мореплавність, традиційну якість ручної роботи та сучасні технології. Просторий інтер\'єр з червоного дерева забезпечує максимальний затишок у тривалих експедиціях.',
                'image_path' => 'Hallberg370.jpg',
                'max_passengers' => 6,
                'length' => '37 ft',
                'width' => '12 ft',
                'cabins' => 2,
                'heads' => 1,
                'engine_power' => '55 hp',
                'engine_model' => 'Volvo Penta D2-55',
                'year' => 2026,
                'condition' => 'New',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id_type' => 4,
                'name_type' => 'Beneteau First 30',
                'short_description' => 'Сучасний легкий гоночний крейсер з акцентом на динаміку та маневреність.',
                'full_description' => 'Beneteau First 30 — це інноваційна модель, розроблена для тих, хто цінує швидкість, легкість керування та сучасний дизайн у поєднанні з функціональністю.',
                'image_path' => 'BeneteauFirst30.jpg',
                'max_passengers' => 4,
                'length' => '30 ft',
                'width' => '10 ft',
                'cabins' => 1,
                'heads' => 1,
                'engine_power' => '20 hp',
                'engine_model' => 'Yanmar 2YM15',
                'year' => 2026,
                'condition' => 'New',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}