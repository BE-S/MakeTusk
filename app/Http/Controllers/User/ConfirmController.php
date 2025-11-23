<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfirmController extends Controller
{
    use ResponseApi;

    public function index(Request $request)
    {
        try {
            $jobHash = $request->jobHash;

            $user = User::where("job_hash", $jobHash)->whereNull("email_verified_at")->first();

            if (!$user) {
                return $this->error("User not found");
            }

            $jobHashTime = Carbon::parse($user->job_hash_created_at);

            //
            // Если хещ просрочен на 12 часов
            //
            if ($jobHashTime->addHours(12)->isPast()) {
                return $this->error("Hash expired");
            }

            $user->email_verified_at   = Carbon::now();
            $user->job_hash            = null;
            $user->job_hash_created_at = null;

            $user->save();

            return $this->success("Email confirmed");
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Post not created. Error " . $exception->getMessage());
        }
    }
}
