<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ClientYacht extends Authenticatable
{
    use Notifiable;

    // Вказуємо таблицю, бо вона має специфічну назву
    protected $table = 'clients_yachts';

    // У нашій таблиці є created_at та updated_at, тому залишаємо timestamps увімкненими
    public $timestamps = true;

    // Поля, які можна заповнювати
    protected $fillable = [
        'full_name', 
        'document_number', 
        'document_issued_by', 
        'document_date', 
        'phone', 
        'email', 
        'password', // Додано поле пароля
        'address', 
        'tax_id'
    ];

    // Приховуємо пароль при виведенні моделі
    protected $hidden = [
        'password',
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