<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification_admin extends Model
{
    use HasFactory;

    protected $table = 'notification_admin'; 

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
