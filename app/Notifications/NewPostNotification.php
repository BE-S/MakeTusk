<?php

namespace App\Notifications;

use App\Mail\PostMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $postId;
    public string $subject;
    public string $title;
    public string $authorName;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $postId, string $subject, string $title, string $authorName)
    {
        $this->postId     = $postId;
        $this->subject    = $subject;
        $this->title      = $title;
        $this->authorName = $authorName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ["mail", "database"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject($this->subject)->view(
            'mail.post-mail',
            [
                "id" => $this->postId,
                "title" => $this->title,
                "author" => $this->authorName
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "id"      => $this->postId,
            "subject" => $this->subject,
            "title"   => $this->title,
            "author"  => $this->authorName
        ];
    }
}
