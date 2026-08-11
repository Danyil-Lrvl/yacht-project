<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentYacht extends Model
{
    // 1. Обов'язково вказуємо, які поля можна заповнювати (mass assignment)
    protected $fillable = [
        'yacht_id', 
        'client_id', 
        'start_date', 
        'end_date', 
        'amount', 
        'status'
    ];

    // 2. Зв'язок: Оренда належить конкретній яхті
    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }

    // 3. Зв'язок: Оренда належить конкретному клієнту
    public function client()
    {
        return $this->belongsTo(ClientYacht::class);
    }
}