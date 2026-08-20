<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $table = 'yachts';
    
    // Додано 'type_oper' та інші необхідні поля до fillable
    protected $fillable = [
        'name', 
        'year', 
        'status', 
        'price_rent', 
        'price_buy', 
        'last_maintenance', 
        'type_oper', 
        'type_id', 
        'registration_date', 
        'is_active', 
        'comment', 
        'quantity'
    ];

    // Зв'язок з типом яхти (враховує первинний ключ id_type у таблиці type_yachts)
    public function type()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }

    // Зв'язок: Яхта має багато оренд
    public function rents()
    {
        return $this->hasMany(RentYacht::class);
    }

    // Зв'язок: Яхта має записи про продажі
    public function sales()
    {
        return $this->hasMany(ProdazhaYacht::class);
    }

    // Зв'язок: Яхта може бути пов'язана з клієнтом через продаж
    public function owner()
    {
        return $this->belongsTo(ClientYacht::class, 'client_id');
    }
}