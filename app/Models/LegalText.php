<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalText extends Model
{
    use HasFactory;
    protected $table = 'legal_texts';
    protected $fillable = ['title', 'content', 'type_contrat_id', 'isActive', 'isDelete'];


    // Relation avec le type de contrat
    public function typeContrat()
    {
        return $this->belongsTo(typeContrat::class, 'type_contrat_id');
    }
}


