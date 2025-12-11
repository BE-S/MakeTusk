<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreateNotificationQueueJob implements ShouldQueue
{
    use Queueable;

    protected Post $post;
    protected string $emailSubject;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, string $emailSubject)
    {
        $this->post = $post;
        $this->emailSubject = $emailSubject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $post = $this->post;
        $emailSubject = $this->emailSubject;


        try {
            //
            // Последовательно получаем по 50 пользователей и рассылаем уведомления
            //
            User::whereNotNull("email_verified_at")
                ->chunk(50, function ($users) use ($post, $emailSubject) {
                    \Illuminate\Support\Facades\Notification::send($users, (new NewPostNotification($post->id, $emailSubject, $post->title, $post->user->name)));
                });
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
        }
    }
}
