<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'department', 'type', 'location',
        'salary_range', 'requirements', 'benefits', 'status',
        'deadline', 'positions_available', 'created_by','companyId'
    ];

    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
        'deadline' => 'date'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getApplicationsCountAttribute()
    {
        return $this->applications()->count();
    }

    public function getActiveApplicationsCountAttribute()
    {
        return $this->applications()->whereNotIn('status', ['rejected', 'withdrawn'])->count();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}
