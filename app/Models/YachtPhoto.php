<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YachtPhoto extends Model
{
    protected $table = 'yacht_photos';
    protected $fillable = ['type_id', 'image_path'];

    // Зв'язок: кожне фото належить до певного типу яхти
    public function typeYacht()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }
}
