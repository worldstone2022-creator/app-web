<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercice_comptable extends Model
{
    use HasFactory;
    protected $dates = ['date_debut_exercice', 'date_fin_exercice'];

}
