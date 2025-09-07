<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_offer_id', 'first_name', 'last_name', 'email', 'phone',
        'address', 'cv_path', 'cover_letter_path', 'message',
        'linkedin_profile', 'portfolio_url', 'experience', 'education',
        'skills', 'status', 'rating', 'notes','companyId'
    ];

    protected $casts = [
        'experience' => 'array',
        'education' => 'array',
        'skills' => 'array'
    ];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function workflows()
    {
        return $this->hasMany(RecruitmentWorkflow::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCurrentStageAttribute()
    {
        return $this->workflows()->latest()->first()?->stage ?? 'Application reçue';
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }
}
