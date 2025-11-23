<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetPostController extends Controller
{
    public function index(int $id)
    {
        try {
            $post = Post::findOrFail($id);

            return new PostResource($post);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
