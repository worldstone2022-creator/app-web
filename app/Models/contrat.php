<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contrat extends Model
{
    use HasFactory;
    protected $table = 'contrats';

    protected $fillable = ['content', 'user_id','legal_text_id', 'isActive', 'isDelete'];
    // Relation avec le text legal
    public function legalText()
    {
        return $this->belongsTo(legalText::class, 'legal_text_id');
    }

    // Relation avec user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
