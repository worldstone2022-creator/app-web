<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MedicalVisit extends Model
{

    use HasFactory;

    protected $fillable = [
        'company_id', 'user_id', 'visit_type', 'visit_object',
        'doctor_name', 'scheduled_date', 'visit_date', 'result',
        'certificate_path', 'notes'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'visit_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getIsOverdueAttribute()
    {
        return $this->scheduled_date < Carbon::today() && $this->result === 'Non effectué';
    }

    public function getDaysUntilVisitAttribute()
    {
        return Carbon::today()->diffInDays($this->scheduled_date, false);
    }
}
