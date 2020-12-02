<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\DefaultNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hasHelpers()
    {
        $this->assertTrue(file_exists(app_path('Support/notification.php')));
        $this->assertTrue(function_exists('notificationDrivers'));
        $this->assertTrue(function_exists('notificationEnabled'));
    }

    /** @test */
    public function hasConfig()
    {
        $this->assertTrue(file_exists(config_path('notification.php')));
        $this->assertTrue(! empty(config('notification.enabled')));
        $this->assertTrue(! empty(config('notification.default')));
    }

    /** @test */
    public function canSendNotification()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $user = User::factory()->create();

        $subject = 'Unit Test Notification';
        $message = 'Unit Test Message';
        $url = route('welcome');

        $user->notify(new DefaultNotification($subject, $message, $url));

        // Assert a specific type of notification was sent meeting the given truth test...
        Notification::assertSentTo(
            $user,
            function (DefaultNotification $notification, $channels) use ($subject, $message, $url) {
                return (
                    $notification->getSubject() === $subject &&
                    $notification->getMessage() === $message &&
                    $notification->getUrl() === $url
                );
            }
        );

        // Assert a notification was sent to the given users...
        Notification::assertSentTo(
            [$user], DefaultNotification::class
        );
    }

    /** @test */
    public function canSeeNotificationPages()
    {
        \Artisan::call('seed:pre');
        $user = User::first();

        $response = $this
            ->actingAs($user)
            ->get('/notifications')
            ->assertStatus(200);

        $subject = 'Unit Test Notification';
        $message = 'Unit Test Message';
        $url = route('welcome');

        $user->notify(new DefaultNotification($subject, $message, $url));

        $response = $this
            ->actingAs($user)
            ->get('/notifications/'.$user->notifications()->first()->id)
            ->assertStatus(200);
    }

    /** @test */
    public function canMarkNotifications()
    {
        \Artisan::call('seed:pre');
        $user = User::first();

        $subject = 'Unit Test Notification';
        $message = 'Unit Test Message';
        $url = route('welcome');

        $user->notify(new DefaultNotification($subject, $message, $url));

        // mark all unread as read
        $this->actingAs($user)
            ->put(route('notifications.mark-all-as-read'))
            ->assertStatus(302)
            ->assertRedirect(route('notifications.index'));

        $this->assertDatabaseHas('notifications', [
            'data' => json_encode([
                'subject' => $subject,
                'message' => $message,
                'url' => $url,
            ]),
        ]);

        // mark all read as unread
        $this->actingAs($user)
            ->put(route('notifications.mark-all-as-unread'))
            ->assertStatus(302)
            ->assertRedirect(route('notifications.index'));

        // mark notification as read
        $this
            ->actingAs($user)
            ->put(route('notifications.mark-as-read', ['id' => $user->notifications()->first()->id]))
            ->assertStatus(302)
            ->assertRedirect(route('notifications.index'));

        // mark notification as unread
        $this
            ->actingAs($user)
            ->put(route('notifications.mark-as-unread', ['id' => $user->notifications()->first()->id]))
            ->assertStatus(302)
            ->assertRedirect(route('notifications.index'));
    }
}
