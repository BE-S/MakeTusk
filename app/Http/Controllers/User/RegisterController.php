<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendMailJob;
use App\Mail\ConfirmationUserMail;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use ResponseApi;

    public function index(RegisterRequest $request)
    {
        try {
            $fields = $request->validated();

            $jobHash = \md5($fields["name"] . $fields["email"]);

            User::create(
                $fields +
                [
                    "job_hash" => $jobHash,
                    "job_hash_created_at" => now()
                ]
            );

            SendMailJob::dispatch($request->email, ConfirmationUserMail::class, $jobHash);

            return $this->success("user created!");
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
