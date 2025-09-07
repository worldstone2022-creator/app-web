<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approvisionnement extends Model
{
    use HasFactory;
    protected $table = 'approvisionnements';

    protected $dates = ['date_transaction'];
}
