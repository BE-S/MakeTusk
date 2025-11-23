<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Jobs\CreateNotificationQueueJob;
use App\Mail\PostMail;
use App\Models\Post;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;

class CreatePostController extends Controller
{
    use ResponseApi;

    public function index(CreatePostRequest $request)
    {
        try {
            $user = User::find($request->user_id);

            $post = Post::create($request->validated());

            CreateNotificationQueueJob::dispatch($user, $post, PostMail::class, "Вышла новая статья!");

            return $this->success("Post created!");
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Post not created. Error " . $exception->getMessage());
        }
    }
}
