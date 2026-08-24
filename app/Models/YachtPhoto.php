<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YachtPhoto extends Model
{
    protected $table = 'yacht_photos';
    protected $fillable = ['type_id', 'yacht_id', 'image_path'];

    // Ваш існуючий зв'язок
    public function typeYacht()
    {
        return $this->belongsTo(TypeYacht::class, 'type_id', 'id_type');
    }

    // ДОДАЙТЕ ЦЕЙ ЗВ'ЯЗОК, щоб помилка зникла:
    public function yacht()
    {
        return $this->belongsTo(Yacht::class, 'yacht_id', 'id');
    }
}