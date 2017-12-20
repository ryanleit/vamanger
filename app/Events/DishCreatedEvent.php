<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Menu;
use App\Restaurant;

class DishCreatedEvent
{
    use InteractsWithSockets, SerializesModels;

    public $restaurant;
    public $menu;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Restaurant $restaurant, Menu $menu)
    {
        $this->restaurant = $restaurant;
        $this->menu = $menu;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
