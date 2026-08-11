<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdazhaYacht extends Model
{
    // Вказуємо назву таблиці, якщо вона не відповідає стандартному множинному числу (за бажанням)
    protected $table = 'prodazha_yachts';

    // Дозволяємо масове заповнення полів
    protected $fillable = [
        'yacht_id', 
        'client_id', 
        'sale_date', 
        'amount', 
        'status'
    ];

    // Зв'язок: Продаж стосується конкретної яхти
    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }

    // Зв'язок: Продаж здійснюється конкретному клієнту
    public function client()
    {
        return $this->belongsTo(ClientYacht::class);
    }
}