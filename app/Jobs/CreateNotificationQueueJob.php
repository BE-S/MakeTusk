<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreateNotificationQueueJob implements ShouldQueue
{
    use Queueable;

    protected User   $user;
    protected Post   $post;
    protected        $mailable;
    protected string $emailSubject;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Post $post, $mailable, string $emailSubject)
    {
        $this->user         = $user;
        $this->post         = $post;
        $this->mailable     = $mailable;
        $this->emailSubject = $emailSubject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $post = $this->post;
        $mailable = $this->mailable;
        $emailSubject = $this->emailSubject;


        try {
            //
            // Последовательно получаем по 50 пользователей и рассылаем уведомления
            //
            $this->user->whereNotNull("email_verified_at")
                ->chunk(50, function ($users) use ($post, $mailable, $emailSubject) {
                    foreach ($users as $user) {
                        //
                        // Ставим в очередь отправку писем
                        //
                        SendMailJob::dispatch($user->email, $mailable, $post->id, $post->title, $emailSubject, $post->user->name);

                        //
                        // Добавляем уведомление в базу для сохранения истории
                        //
                        Notification::create([
                            "user_id" => $user->id,
                            "post_id" => $post->id
                        ]);
                    }
                });
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
        }
    }
}
