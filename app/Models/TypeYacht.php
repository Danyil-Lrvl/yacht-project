<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeYacht extends Model
{
    protected $table = 'type_yachts';
    
    // Вказуємо, що primary key — це id_type
    protected $primaryKey = 'id_type';
    
    // Дозволяємо масове заповнення (додали описи!)
    protected $fillable = [
        'name_type', 
        'short_description', 
        'full_description', 
        'max_passengers', 
        'length', 
        'width', 
        'cabins', 
        'heads', 
        'engine_power', 
        'engine_model', 
        'year', 
        'condition', 
        'image_path'
    ];

    // Зв'язок: один тип має багато фото
    public function photos()
    {
        return $this->hasMany(YachtPhoto::class, 'type_id', 'id_type');
    }
    
    // Зв'язок: один тип має багато яхт
    public function yachts()
    {
        return $this->hasMany(Yacht::class, 'type_id', 'id_type');
    }
}