<?php

// app/Models/Thematique.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thematique extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($thematique) {
            $thematique->slug = Str::slug($thematique->nom);
        });
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}