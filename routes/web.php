<?php

use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\FavoriteReplyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadSubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('threads');
});

Route::get('threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('threads', [ThreadController::class, 'store'])->name('threads.store')->middleware('auth');
Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.create')->middleware('auth');
Route::get('threads/{channel:slug}/{thread}', [ThreadController::class, 'show'])->name('threads.show')->scopeBindings();

Route::get('threads/{channel:slug}', [ThreadController::class, 'index']);

Route::post('threads/{thread}/replies', [ReplyController::class, 'store'])->middleware('auth')->name('threads.replies.store');

Route::patch('replies/{reply}', [ReplyController::class, 'update'])->middleware('auth');
Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])->middleware('auth');

Route::post('replies/{reply}/favorites', [FavoriteReplyController::class, 'store'])->middleware('auth');
Route::delete('replies/{reply}/favorites', [FavoriteReplyController::class, 'destroy'])->middleware('auth');

Route::post('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'store'])->middleware('auth');
Route::delete('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'destroy'])->middleware('auth');

Route::delete('threads/{channel:slug}/{thread}', [ThreadController::class, 'destroy'])->middleware('auth')->name('threads.destroy')->scopeBindings();

Route::get('profiles/{user:name}', [ProfileController::class, 'show']);

require __DIR__ . '/auth.php';
