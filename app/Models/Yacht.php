<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $table = 'yachts';
    protected $primaryKey = 'id';
    
    // Вказуємо правильні назви колонок, які є у вашій базі даних
    protected $fillable = [
        'name', 
        'status', 
        'type_id',
        'serial_number',
        'year', 
        'price_rent', 
        'price_buy', 
        'type_oper', 
        'last_maintenance', 
        'registration_date', 
        'is_active', 
        'comment'
    ];

    protected $attributes = [
        'status' => 'available',
    ];

    // Зв'язок тепер точно відповідає колонці type_id у таблиці yachts
    public function type()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }

    public function rents()
    {
        return $this->hasMany(RentYacht::class, 'yacht_id');
    }

    public function sales()
    {
        return $this->hasMany(ProdazhaYacht::class, 'yacht_id');
    }

    public function owner()
    {
        return $this->belongsTo(ClientYacht::class, 'client_id');
    }
}