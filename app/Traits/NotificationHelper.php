<?php

namespace App\Traits;

use App\Enums\NotificationsTypes;

class NotificationHelper
{
    public static function sendPushNotification(array $fcmTokens, array $data, $type): string
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $apiKey = 'token';
        $header = [
            "authorization: key=" . $apiKey,
            "content-type: application/json",
        ];
        $value = NotificationsTypes::PushNotifications;
        $type = NotificationsTypes::getName($value);

        $payloads = [];
        foreach ($fcmTokens as $token) {
            if (isset($token)) {
                switch ($type) {
                    case 'Orders':
                    case 'Offers':
                        $payloads[] = NotificationHelper::buildPayload($token, $data);
                        break;
                    case 'PushNotifications':
                        $payloads[] = NotificationHelper::buildPayload($token, $data);
                        break;
                    default:
                        break;
                }
            }
        }


        $responses = [];

        foreach ($payloads as $payload) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 120,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => $header,
            ]);

            $response = curl_exec($ch);
            $responses[] = $response;
            curl_close($ch);
        }

        return json_encode($responses);
    }

    public static function sendPushNotificationToTopic(string $topic, array $data, $type): string
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $apiKey = 'AAAA-FF9gFg:APA91bHzhsnzPFmUDOKVoV70tJcn6Wsb4mInxzbrcRKmm2vvTgZkuPfx6f3MPpyzjSmPR0p0ly7x16UxOd4LdPeOm-LJLhy6JmAMBtUfPu6aidQMyyOm6aWOgXrccMZQyf6BfPCLBMPX';
        $header = [
            "authorization: key=" . $apiKey,
            "content-type: application/json",
        ];
        $payload = NotificationHelper::buildPayload($topic, $data);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $header,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private static function buildPayload(string $fcmToken, array $data): string
    {
        $payload = [
            "to" => $fcmToken,
            "data" => [
                "title" => $data['title'],
                "body" => $data['body'],
            ],
            "notification" => [
                "title" => $data['title'],
                "body" => $data['body'],
            ],
        ];
        return json_encode($payload);
    }
}
