<?php

use App\Http\Controllers\User\ConfirmController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::get("/confirm-password/{jobHash}", [ConfirmController::class, "index"])->name("get.confirm-password");

Route::prefix("admin")->group(function () {
    Route::get("users", [UsersController::class, "index"]);
});
