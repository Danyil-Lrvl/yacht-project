<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $table = 'yachts';
    
    // Поля, які можна масово заповнювати (додали 'quantity')
    protected $fillable = ['name', 'type_id', 'price_rent', 'price_buy', 'short_description', 'image_path', 'description', 'quantity'];

    // Зв'язок з типом яхти
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