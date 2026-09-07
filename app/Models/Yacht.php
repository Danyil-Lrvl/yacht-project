<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $table = 'yachts';
    protected $primaryKey = 'id';
    
    // Додано 'client_id', щоб працювало масове заповнення для власника
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
        'comment',
        'client_id' 
    ];

    protected $attributes = [
        'status' => 'available',
    ];

    // Зв'язок з типом яхти
    public function type()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }

    // Зв'язок з орендами
    public function rents()
    {
        return $this->hasMany(RentYacht::class, 'yacht_id');
    }

    // Зв'язок з продажами (через окрему таблицю prodazha_yachts)
    public function sales()
    {
        return $this->hasMany(ProdazhaYacht::class, 'yacht_id');
    }

    // Зв'язок з власником (клієнтом)
    public function owner()
    {
        return $this->belongsTo(ClientYacht::class, 'client_id');
    }
}