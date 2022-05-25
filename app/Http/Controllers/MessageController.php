<?php


namespace App\Http\Controllers;

use App\Models\MessageModel;

class MessageController
{

    public function getMessagesOnUserId($userId): array
    {
        return MessageModel::query()->where("user_id", "=", $userId)->get()->all();
    }

    public function deleteMessagesOnUserId($userId) {
        return MessageModel::query()->where("user_id", "=", $userId)->delete();
    }

}
