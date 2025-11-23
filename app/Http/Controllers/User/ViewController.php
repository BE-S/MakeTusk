<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ViewController extends Controller
{
    //
    // Полечение пользовалей с использованием пагинации, для эффективной работы фронта
    //
    public function index()
    {
        try {
            $users = User::cursorPaginate(15);

            return UsersResource::collection($users);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
