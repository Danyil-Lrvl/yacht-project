<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientYacht extends Model
{
    // Вказуємо таблицю, бо вона має специфічну назву
    protected $table = 'clients_yachts';

    // Вказуємо, що Eloquent не повинен шукати поля created_at/updated_at
    public $timestamps = false;

    // Поля, які можна заповнювати
    protected $fillable = [
        'full_name', 
        'document_number', 
        'document_issued_by', 
        'document_date', 
        'phone', 
        'email', 
        'address', 
        'tax_id'
    ];

    // Зв'язок: Клієнт має багато оренд
    public function rents()
    {
        return $this->hasMany(RentYacht::class, 'client_id');
    }

    // Зв'язок: Клієнт має багато покупок
    public function sales()
    {
        return $this->hasMany(ProdazhaYacht::class, 'client_id');
    }
}