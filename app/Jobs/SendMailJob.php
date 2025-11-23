<?php

namespace App\Jobs;

use App\Mail\ConfirmationUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    protected string $email;
    protected        $mailable;
    protected  array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, $mailable, ...$data)
    {
        $this->email    = $email;
        $this->mailable = $mailable;
        $this->data     = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $mailable = $this->mailable;

            Mail::to($this->email)->send(new $mailable(...$this->data));
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
        }

    }
}
