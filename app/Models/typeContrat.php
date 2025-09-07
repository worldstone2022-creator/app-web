<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class typeContrat extends Model
{
    use HasFactory;
    protected $table = 'type_contrats';
    protected $fillable = ['name', 'description', 'added_by', 'last_updated_by'];
    
    public function legalTexts()
    {
        return $this->hasMany(LegalText::class, 'type_contrat_id');
    }
    public function employees()
    {
        return $this->hasMany(EmployeeDetails::class, 'typeContrat_id')
                    ->with('user');
    }
    
}
