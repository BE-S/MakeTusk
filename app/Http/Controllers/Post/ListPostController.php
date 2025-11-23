<?php

namespace App\Http\Controllers\Post;

use App\Enums\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\ListPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;

class ListPostController extends Controller
{
    use ResponseApi;

    public function index(ListPostRequest $request)
    {
        try {
            $order = $request->get("order");

            $posts = Post::order($order)->with("user")->paginate(15);

            return PostResource::collection($posts);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
