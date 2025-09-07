<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class critere_appreciation extends Model
{
    use HasFactory;
    protected $table = 'critere_appreciations';
    protected $fillable = ['name', 'description', 'isActive', 'isDelete'];

}
