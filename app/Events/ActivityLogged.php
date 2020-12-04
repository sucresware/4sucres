<?php

namespace App\Events;

use App\Models\Activity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityLogged implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $activity_id;

    public function __construct(Activity $activity)
    {
        $this->activity_id = $activity->id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('Activities');
    }
}
