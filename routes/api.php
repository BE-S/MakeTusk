<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\GetPostController;
use App\Http\Controllers\Post\ListPostController;
use App\Http\Controllers\User\GetController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ViewController;

Route::post("notifications", [NotificationController::class, "index"]);

Route::prefix("admin")->group(function () {
    Route::post("register", [RegisterController::class, "index"]);
});

Route::prefix("users")->group(function () {
    Route::get("/", [GetController::class, "index"]);
    Route::get("/cursor/pagination", [ViewController::class, "index"])->name("get.users-pagination"); // Список пользователей с пагинацией Cursor
});

Route::prefix("posts")->group(function () {
    Route::get("/",     [ListPostController::class, "index"]);
    Route::get("/{id}", [GetPostController::class,  "index"])->name("get.post");
    Route::post("/",    [CreatePostController::class,  "index"]);
});
