<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function rules()
    {
        return [
            'content' => 'max:4294967295',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subject_()
    {
        return $this->belongsTo(Subject::class, 'subject', 'id');
    }

    public function category_()
    {
        return $this->belongsTo(PostCategories::class, 'category', 'id');
    }

    public function specialized_()
    {
        return $this->belongsTo(Specialized::class, 'specialized', 'id');
    }

    public function school_year_()
    {
        return $this->belongsTo(School_year::class, 'school_year', 'id');
    }

    public function type_()
    {
        return $this->belongsTo(Type::class, 'type', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')->orderBy('id', 'DESC');
    }

    
    public function tags()
{
    return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
}
}
