<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GetController extends Controller
{
    public function index()
    {
        try {
            return UsersResource::collection(User::all());
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
