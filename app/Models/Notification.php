<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getNotificationsForCurrentUser()
    {
        // Lấy thông tin người dùng đang đăng nhập
        $owner_id = auth()->id();

        // Truy vấn database để lấy ra các thông báo của người dùng
        $notifications = Notification::where('user_id', '!=', $owner_id )->where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();

        return $notifications;
    }
}
