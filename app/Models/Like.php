<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function hasLiked($user_id, $post_id)
    {
        return $this->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->exists();
    }
}
