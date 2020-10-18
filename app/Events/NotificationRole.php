<?php

namespace App\Events;

use App\Models\ImageFile;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;

class NotificationRole  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Role $role;
    public Notification $notification;
    public $imageFile;

    /**
     * Create a new event instance.
     *
     * @param Role $role
     * @param Notification $notification
     */
    public function __construct(Role $role, Notification $notification)
    {
        $this->role = $role;
        $this->notification = $notification;
        if(!empty($notification->getImage())){
            $this->imageFile = $notification->getImage();
        }else{
            $this->imageFile = ['extension' => ''];
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel ('role_channel.'. $this->role->id);
    }

    public function broadcastAs()
    {
        return 'role_event';
    }
}
