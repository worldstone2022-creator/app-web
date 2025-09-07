<?php

namespace App\Events;

use App\Models\salaire_bulletin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BulletinSalaireEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bulletin;
    public $notifyUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(salaire_bulletin $bulletin, $notifyUser)
    {
        $this->bulletin = $bulletin;
        $this->notifyUser = $notifyUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    /*public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }*/
}
