<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\JobDashboard;

Route::view("/", "welcome");



Route::middleware(["auth"])->group(function () {
    Route::get("/dashboard", JobDashboard::class)->name("dashboard");
    Route::get("/test", function () {
        runBackgroundJob("App\\Jobs\\TestJob", "test_me", ["Musa", "Jali"]);
    });
});
Route::view("profile", "profile")
    ->middleware(["auth"])
    ->name("profile");

require __DIR__ . '/auth.php';
