<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use App\Models\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventNotification extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Un nouvel événement a été planifié.')
                    ->line('Titre: ' . $this->event->title)
                    ->line('Description: ' . $this->event->description)
                    ->line('Date: ' . $this->event->event_date)
                    ->line('Merci de votre attention.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->event->title,
            'description' => $this->event->description,
            'event_date' => $this->event->event_date,
        ];
    }
}
