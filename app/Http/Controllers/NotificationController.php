<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use ResponseApi;

    public function index(GetNotificationRequest $request)
    {
        try {
            $field = $request->validated();

            $user = User::findOrFail($field["user_id"]);

            $notifications = $user->notifications()->get();
            $user->unreadNotifications()->lockForUpdate()->update(['read_at' => now()]);

            return NotificationResource::collection($notifications);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
