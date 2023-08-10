<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use App\Jobs\NewOrderCreatedNotificationProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewOrderCreatedListener
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
    public function handle(NewOrderCreatedEvent $event): void
    {
        //
        NewOrderCreatedNotificationProcessing::dispatch( $event->order )
            ->onQueue('notifications')
            ->delay(now()->addSeconds(rand(3, 8) ));
    }
}
