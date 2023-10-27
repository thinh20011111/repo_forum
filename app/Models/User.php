<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',

        'avatar',
        'background',
        'birthday',
        'adress',
        'gender',
        'phone',
        'bio',
        'class',
        'status',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id', 'id');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'owner_id', 'id');
    }

    public function getPostCount($userId)
    {
        $user = User::findOrFail($userId);
        $postCount = $user->posts()
            ->whereNull('daily_post')
            ->whereNull('story_post')
            ->count();

        return $postCount;
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'id', 'sender');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'id', 'receiver');
    }

    public function isFollowing()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
}
