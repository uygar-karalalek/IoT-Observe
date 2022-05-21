<?php


namespace App\Http\Controllers;


use App\Models\MessageModel;
use Illuminate\Http\Request;

class MessageController
{

    public function getMessagesOnUserId($userId) {
        return MessageModel::query()->where("user_id", "=", $userId)->get()->all();
    }
    public function deleteMessagesOnUserId($userId) {
        return MessageModel::query()->where("user_id", "=", $userId)->delete();
    }

}
