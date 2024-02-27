<?php

namespace App\Notifications;

use App\Enums\NotificationsTypes;
use App\Traits\NotificationHelper;

class NotificationSender
{

    public static function sendPushNotification($users , $title , $body)
    {


        // App::setlocale('ar');

        $data = [
            'title' => $title,
            'body' => $body,
        ];


        $fcmTokens = $users->pluck('fcm_token');

        NotificationHelper::sendPushNotification($fcmTokens->toArray(), $data , NotificationsTypes::PushNotifications);

        return $data = [
            'title'   => $title,
            'body'    => $body,
            'type' => NotificationsTypes::PushNotifications,
        ];
    }
}
