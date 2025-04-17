<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewCommentNotify extends Notification implements ShouldBroadcast , ShouldQueue
{
    use Queueable;

    public $comment;
    public $post;
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;

        Log::info('Event is being dispatched.');
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase(object $notifiable)
    {
        return [
            'user_id' => $this->comment->user_id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' => $this->post->slug,
        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'user_id' => $this->comment->user_id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' => $this->post->slug,

        ];
    }
    public function broadcastType(): string
    {
        return 'NewCommentNotify';
    }

    public function databaseType(object $notifiable): string
    {
        return 'NewCommentNotify';
    }
}
