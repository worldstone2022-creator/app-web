<?php

namespace App\Listeners;

use App\Events\AnnualLeaveEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnnualLeaveListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnnualLeaveEvent $event): void
    {
        //
    }
}
