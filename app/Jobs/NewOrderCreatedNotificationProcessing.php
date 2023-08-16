<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\Orders\Created\NewOrderCreatedAdminNotification;
use App\Notifications\Orders\Created\NewOrderCreatedCustomerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NewOrderCreatedNotificationProcessing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        logs()->info(self::class);

        $this->order->notify(
            app()->make(NewOrderCreatedCustomerNotification::class)
        );

        Notification::send(
            User::role('admin')->get(),
            new NewOrderCreatedAdminNotification($this->order)
        );
    }
}
