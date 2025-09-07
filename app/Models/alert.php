<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alert extends Model
{
    use HasFactory;
    protected $dates = ['date_execution_tache', 'date_rappel_debut', 'date_rappel_fin'];
}
