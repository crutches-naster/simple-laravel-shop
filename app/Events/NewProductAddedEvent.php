<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class NewProductAddedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public string $product_title, $product_url;

    public function __construct( $product )
    {
        $this->product_title = $product->title;
        $this->product_url = route('products.show', $product);

        $this->broadcastVia('pusher');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('my-channel')
        ];
    }

}
