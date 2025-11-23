<?php

namespace App\Traits;

trait ResponseApi
{
    public function success($message, $status = 200)
    {
        return response()->json([
            "status"  => "success",
            "message" => $message
        ]);
    }

    public function error($message, $status = 403)
    {
        return response()->json([
            "status"  => "error",
            "message" => $message
        ]);
    }
}
