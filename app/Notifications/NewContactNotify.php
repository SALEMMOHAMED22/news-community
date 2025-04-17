<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

class NewContactNotify extends Notification implements ShouldBroadcast , ShouldQueue
{
    use Queueable;

    public $contact;
    public function __construct($contact )
    {
        $this->contact = $contact;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database' , 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }
    // public function broadcastOn()       
    // {
    //         return new PrivateChannel('admins.' . $this->contact->id);
    // }
    

    public function toArray(object $notifiable)
    {
        return [
            'contact_title' => $this->contact->title,
            'contact_name' => $this->contact->name,
            'date' => date('y-m-d h:m a'),
            'link' => route('admin.contacts.show' , $this->contact->id),
        ];
    }
    public function broadcastType(): string
    {
        return 'NewContactNotify';
    }

    public function databaseType(object $notifiable): string
    {
        return 'NewContactNotify';
    }
}
