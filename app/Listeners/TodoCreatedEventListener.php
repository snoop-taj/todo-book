<?php

namespace App\Listeners;

use App\Events\TodoCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TodoCreatedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TodoCreatedEvent  $event
     * @return void
     */
    public function handle(TodoCreatedEvent $event)
    {
        //
    }
}
