<?php

namespace App\Events;

use App\Todo;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TodoCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var User */
    public $user;

    /** @var Todo */
    public $todo;

    /**
     * Create a new event instance.
     *
     * @param Todo $todo
     * @param User $user
     */
    public function __construct(Todo $todo, User $user)
    {
        $this->todo = $todo;
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Todo
     */
    public function getTodo(): Todo
    {
        return $this->todo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        $receivers = [];

        $todo = $this->getTodo();
        $user = $this->getTodo();

        if ($todo->isPublic()) {
            $receivers = User::where('id', '!=', $user->id)->get();
        } else {
            $receivers = $user->friends;
        }

        foreach ($receivers as $user) {
            $channels[] = new PrivateChannel('App.User.' . $user->id);
        }

        return $channels;
    }
}
