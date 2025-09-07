<?php

namespace App\Models;
//use App\Observers\BulletinSalaireObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class salaire_bulletin extends BaseModel
{
    use HasFactory;

    public function members()
    {
        return $this->hasMany(EmployeeDetails::class, 'designation_id');
    }

    public static function allSalaireBulletin()
    {
        //if (user()->permission('view_designation') == 'all' || user()->permission('view_designation') == 'none') {
            return salaire_bulletin::all();
        //}

        //return Designation::where('added_by', user()->id)->get();
    }
}



