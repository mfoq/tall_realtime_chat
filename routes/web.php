<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Chat\Chat;
use App\Livewire\Chat\Index;
use App\Livewire\Dashboard;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/chat', Index::class)->name('chat.index');
    Route::get('/chat/{query}', Chat::class)->name('chat.show');
    Route::get('/users', Users::class)->name('users');
});
