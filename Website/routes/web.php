<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Models\Message;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
    Route::post('/friends', [FriendsController::class, 'store'])->name('friends.store');
    Route::delete('/friends/{friend}', [FriendsController::class, 'remove'])->name('friends.remove');
});

Route::get('/chats', function () {
    $user = Auth::user();
    $messages = Message::where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id)
        ->orderBy('created_at')
        ->get();

    return view('chats.chats', compact('messages'));
})->name('chats.index')->middleware('auth');
Route::post('/chats/send', [MessageController::class, 'send'])->name('chats.send')->middleware('auth');
Route::post('/chats/clear', [MessageController::class, 'clearChats'])->name('chats.clear')->middleware('auth');


require __DIR__.'/auth.php';
