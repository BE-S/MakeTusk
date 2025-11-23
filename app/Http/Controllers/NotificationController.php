<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index(GetNotificationRequest $request)
    {
        try {
            $field = $request->validated();

            $notifications = Notification::where("user_id", $field["user_id"])->get();

            return NotificationResource::collection($notifications);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return $this->error("Error " . $exception->getMessage());
        }
    }
}
