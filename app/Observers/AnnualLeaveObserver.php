<?php

namespace App\Observers;

use App\Models\annualLeave;
use App\Models\User;

use App\Events\AnnualLeaveEvent;

class AnnualLeaveObserver
{
    /**
     * Handle the annualLeave "created" event.
     *
     * @param  \App\Models\annualLeave  $annualLeave
     * @return void
     */
    public function created(annualLeave $annualLeave)
    {
        if (!isRunningInConsoleOrSeeding()) {
            event(new AnnualLeaveEvent($annualLeave, 'created')); 
        }
    }

    /**
     * Handle the annualLeave "updated" event.
     *
     * @param  \App\Models\annualLeave  $annualLeave
     * @return void
     */
    public function updated(annualLeave $annualLeave)
    {
        if (!isRunningInConsoleOrSeeding()) {

            if ($annualLeave->isDirty('status')) {
                event(new AnnualLeaveEvent($annualLeave, 'statusUpdated'));
            }
            else {
                event(new AnnualLeaveEvent($annualLeave, 'updated'));
            }

        }
    }

    /**
     * Handle the annualLeave "deleted" event.
     *
     * @param  \App\Models\annualLeave  $annualLeave
     * @return void
     */
    public function deleted(annualLeave $annualLeave)
    {
        //
    }

    /**
     * Handle the annualLeave "restored" event.
     *
     * @param  \App\Models\annualLeave  $annualLeave
     * @return void
     */
    public function restored(annualLeave $annualLeave)
    {
        //
    }

    /**
     * Handle the annualLeave "force deleted" event.
     *
     * @param  \App\Models\annualLeave  $annualLeave
     * @return void
     */
    public function forceDeleted(annualLeave $annualLeave)
    {
        //
    }
}
