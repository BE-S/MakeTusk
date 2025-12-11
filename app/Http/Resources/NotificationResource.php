<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"     => $this->data["id"],
            "author" => $this->data["author"],
            "title"  => $this->data["title"],
            "viewed" => (bool) $this->read_at
        ];
    }
}
