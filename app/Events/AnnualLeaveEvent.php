<?php

namespace App\Events;
use App\Models\annualLeave;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnnualLeaveEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $annualLeave;
    public $status;
    //public $multiDates;

    public function __construct(annualLeave $annualLeave, $status)
    {
        $this->annualLeave = $annualLeave;
        $this->status = $status;
        //$this->multiDates = $multiDates;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

