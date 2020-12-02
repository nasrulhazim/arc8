<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

if (notificationEnabled()) {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');

    // Mark all unread notifications as read
    Route::middleware('auth')->put('/notifications/mark-all-as-read', function (Request $request) {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index');
    })->name('notifications.mark-all-as-read');

    // Mark all read notifications as unread
    Route::middleware('auth')->put('/notifications/mark-all-as-unread', function (Request $request) {
        $request->user()->notifications()->update(['read_at' => null]);

        return redirect()->route('notifications.index');
    })->name('notifications.mark-all-as-unread');

    // Mark notification as read
    Route::middleware('auth')->put('/notifications/{id}/mark-as-read', function (Request $request, $id) {
        $request->user()->notifications()->whereId($id)->update(['read_at' => now()]);

        return redirect()->route('notifications.index');
    })->name('notifications.mark-as-read');

    // Mark read notification as unread
    Route::middleware('auth')->put('/notifications/{id}/mark-as-unread', function (Request $request, $id) {
        $request->user()->notifications()->whereId($id)->update(['read_at' => null]);

        return redirect()->route('notifications.index');
    })->name('notifications.mark-as-unread');
}
