<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'fichier_pdf',
        'url_externe',
        'date_publication',
        'source_id',
        'actif'
    ];

    protected $casts = [
        'date_publication' => 'date',
        'actif' => 'boolean'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function thematiques()
    {
        return $this->belongsToMany(Thematique::class);
    }

    public function getFichierUrlAttribute()
    {
        if ($this->fichier_pdf) {
            return Storage::url($this->fichier_pdf);
        }
        return $this->url_externe;
    }

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeParThematique($query, $thematiqueSlug)
    {
        return $query->whereHas('thematiques', function ($q) use ($thematiqueSlug) {
            $q->where('slug', $thematiqueSlug);
        });
    }

    public function scopeParSource($query, $sourceType)
    {
        return $query->whereHas('source', function ($q) use ($sourceType) {
            $q->where('type', $sourceType);
        });
    }
}