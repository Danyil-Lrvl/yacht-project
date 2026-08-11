<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YachtSpec extends Model
{
    protected $table = 'yacht_specs';
    // Оновлено fillable: тепер ми використовуємо type_id замість yacht_id
    protected $fillable = ['type_id', 'length', 'width', 'cabins', 'heads', 'engine_power', 'engine_model', 'year', 'condition'];

    // Тепер характеристика належить до типу яхти
    public function typeYacht()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }
}