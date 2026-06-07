<?php

namespace App\Services;

use App\Jobs\SendPushNotificationJob;
use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected PushNotificationService $push;

    public function __construct(PushNotificationService $push)
    {
        $this->push = $push;
    }

    /**
     * Send a notification to a user (DB row + FCM push via job)
     *
     * @param User|int $userOrId
     * @param string $title
     * @param string $body
     * @param array $data
     * @param string|null $type
     */
    public function notifyUser($userOrId, string $title, string $body, array $data = [], ?string $type = null): void
    {
        $userId = $userOrId instanceof User ? $userOrId->id : (int)$userOrId;

        // get device tokens for this user
        $tokens = DeviceToken::where('user_id', $userId)
            ->pluck('token')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
        // dispatch job (queued)
        dispatch(new SendPushNotificationJob($tokens, $userId, $title, $body, $data, $type));
    }

    /**
     * Send a broadcast to topic or many tokens (optional)
     */
    public function notifyTokens(array $tokens, string $title, string $body, array $data = []): void
    {
        dispatch(new SendPushNotificationJob($tokens, null, $title, $body, $data, null));
    }
}



// Uses Send Push Notification 
// app(NotificationService::class)->notifyUser(
//     $order->user_id,
//     "Order #{$order->order_id} is now: " . ucwords(str_replace('_', ' ', $req->status)),
//     "Your order status changed to " . ucwords(str_replace('_', ' ', $req->status)),
//     ['order_id' => $order->id, 'status' => $req->status],
//     'order_tracking'
// );
