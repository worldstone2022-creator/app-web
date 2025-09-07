<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'nom'
    ];

    const TYPES = [
        'loi' => 'Loi',
        'decret' => 'Décret',
        'convention_collective' => 'Convention collective',
        'jurisprudence' => 'Jurisprudence',
        'arrete' => 'Arrêté',
        'circulaire' => 'Circulaire'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getTypeLibelleAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
