<?php

namespace App\Services;

use App\Enums\NotificationsTypes;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Notification;
use App\Notifications\NotificationSender;

class NotificationService
{
    use ModelHelper;

    public function __construct(private UserService $userService)
    {

    }
    public function getAll()
    {
        $user = request()->user();
        if(request()->has('type')){
            $type = NotificationsTypes::getValue(request()->type);
            return $user->notifications()->where('type', $type)->get();
        }
        return $user->notifications;
    }

    public function find($notificationId)
    {
        return Notification::findOrFail($notificationId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $notification = Notification::create($validatedData);

        DB::commit();

        return $notification;
    }

    public function update($validatedData, $notificationId)
    {
        $notification = Notification::findOrFail($notificationId);

        DB::beginTransaction();

        $notification->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($notificationId)
    {
        $notification = $this->find($notificationId);

        DB::beginTransaction();

        $notification->delete();

        DB::commit();

        return true;
    }
    public function sendPushNotification($validatedData)
    {
        DB::beginTransaction();

        $users = $this->userService->getUsersByIds($validatedData['user_ids']);
        NotificationSender::sendPushNotification($users,$validatedData['data']['title'],$validatedData['data']['body']);
        foreach($users as $user)
        {
            $notificationData = [
                'type' => NotificationsTypes::PushNotifications,
                'notifiable_type' => get_class($user),
                'notifiable_id' => $user->id,
                'data' => [
                    'title' => $validatedData['data']['title'],
                    'body' => $validatedData['data']['body'],
                ],
            ];
            $notifications[] = $notificationData;
        }
        foreach ($notifications as $data) {
            Notification::create($data);
        }
        DB::commit();
    }
}
