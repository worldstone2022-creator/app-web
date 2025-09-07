<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id', 'type', 'scheduled_at', 'duration_minutes',
        'location', 'meeting_link', 'agenda', 'interviewer_id',
        'additional_interviewers', 'status', 'feedback', 'rating',
        'evaluation_criteria'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'additional_interviewers' => 'array',
        'evaluation_criteria' => 'array'
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', 'scheduled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_at', today());
    }
}