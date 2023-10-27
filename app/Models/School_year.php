<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School_year extends Model
{
    use HasFactory;
    
    protected $fillable = ['year', 'name'];

    public function posts()
    {
        return $this->hasMany(Post::class,'school_year','id');
    }
}
