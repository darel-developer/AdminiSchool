<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventNotification extends Notification
{
    use Queueable;
    private $event;

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

    public function toDatabase($notifiable)
    {
        return [
            'event_title' => $this->event->title,
            'event_date' => $this->event->event_date,
            'event_time' => $this->event->event_time,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Un nouvel événement a été créé : ' . $this->event->title)
                    ->action('Voir l\'événement', url('/events/' . $this->event->id))
                    ->line('Thank you for using our application!');
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
