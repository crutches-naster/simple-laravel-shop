<?php

namespace App\Notifications\Orders\Created;

use App\Enums\OrderStatuses;
use App\Services\Invoices\InvoicesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class NewOrderCreatedCustomerNotification extends Notification
{
    use Queueable;

    protected InvoicesService $invoicesService;

    /**
     * Create a new notification instance.
     */
    public function __construct(InvoicesService $i_Service)
    {
        //
        $this->invoicesService = $i_Service;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        logs()->info(self::class);

        $invoice = $this->invoicesService->generate($notifiable);

        return (new MailMessage)
            ->greeting("Hello, $notifiable->name $notifiable->surname")
            ->line('Your order was created!')
            ->lineIf(
                $notifiable->status->getName() === OrderStatuses::Paid->value,
                'And successfully paid!'
            )
            ->line('You can see the invoice file in attachments')
            ->attach(Storage::disk('public')->path($invoice->filename), [
                'as' => $invoice->filename,
                'mime' => 'application/pdf'
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
