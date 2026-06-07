<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class PushNotificationService
{
    protected Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    /**
     * Send to device tokens
     */
    public function sendToTokens(array $tokens, string $title, string $body, array $data = []): array
    {
        if (empty($tokens)) {
            return ['success' => false, 'message' => 'No tokens'];
        }

        $notification = FcmNotification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

        $report = $this->messaging->sendMulticast($message, $tokens);

        $successCount = $report->successes()->count();
        $failureCount = $report->failures()->count();

        return [
            'success'       => $successCount > 0,
            'successCount'  => $successCount,
            'failureCount'  => $failureCount,
            'failures'      => $report->failures(),
        ];
    }

    // public function sendToTokens(array $tokens, string $title, string $body, array $data = []): array
    // {
    //     Log::info('PushNotificationService::sendToTokens called', [
    //         'tokens' => $tokens,
    //         'title' => $title,
    //         'body' => $body,
    //         'data' => $data,
    //     ]);

    //     if (empty($tokens)) {
    //         Log::warning('No tokens provided for push notification');
    //         return ['success' => false, 'message' => 'No tokens'];
    //     }

    //     try {
    //         $notification = FcmNotification::create($title, $body);

    //         $message = CloudMessage::new()
    //             ->withNotification($notification)
    //             ->withData($data);

    //         $report = $this->messaging->sendMulticast($message, $tokens);

    //         $successCount = $report->successes()->count();
    //         $failureCount = $report->failures()->count();

    //         $failureDetails = [];
    //         foreach ($report->failures()->getItems() as $failure) {
    //             $failureDetails[] = [
    //                 'token' => $failure->target()->value(),
    //                 'error' => $failure->error()->getMessage(),
    //             ];
    //         }

    //         Log::info('FCM multicast send result', [
    //             'success_count' => $successCount,
    //             'failure_count' => $failureCount,
    //             'failures' => $failureDetails,
    //         ]);

    //         return [
    //             'success' => $successCount > 0,
    //             'successCount' => $successCount,
    //             'failureCount' => $failureCount,
    //             'failures' => $failureDetails,
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Failed to send push notification to FCM', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'tokens' => $tokens,
    //             'title' => $title,
    //             'body' => $body,
    //             'data' => $data,
    //         ]);

    //         return [
    //             'success' => false,
    //             'message' => 'FCM error: ' . $e->getMessage(),
    //             'successCount' => 0,
    //             'failureCount' => count($tokens),
    //             'failures' => [['error' => $e->getMessage()]],
    //         ];
    //     }
    // }

    /**
     * Send to a topic broadcast push (e.g. send to all Rank A users, or a "new drop live" notification)
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): array
    {
        $notification = FcmNotification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data)
            ->withChangedTarget('topic', $topic);

        $this->messaging->send($message);

        return ['success' => true];
    }
}
