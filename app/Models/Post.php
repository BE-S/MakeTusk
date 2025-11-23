<?php

namespace App\Models;

use App\Enums\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "anons",
        "text",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function order()
    {
        return match ($order ?? Order::NEWER->value) {
            Order::NEWER->value => self::latest(),
            Order::OLDEST->value => self::oldest()
        };
    }
}
