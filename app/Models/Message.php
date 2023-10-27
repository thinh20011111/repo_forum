<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender', 'receiver', 'content'];

    public function getMessages()
    {
        $messages = Message::orderBy('sent_time', 'asc')->get();

        return $messages;
    }

    public function infor_sender()
    {
        return $this->belongsTo(User::class, 'sender', 'id');
    }

    public function infor_receiver()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}
