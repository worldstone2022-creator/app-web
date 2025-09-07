<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Observers\AnnualLeaveObserver;

class annualLeave extends Model
{
    use HasFactory;
    protected $dates = ['leave_date_debut', 'leave_date_fin'];
    protected $guarded = ['id'];
    protected static function boot()
    {
        parent::boot();
        static::observe(AnnualLeaveObserver::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }
}
