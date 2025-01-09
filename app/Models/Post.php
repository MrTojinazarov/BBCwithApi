<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'text',
        'img',
        'likes',    
        'dislikes',   
        'views',      
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function viewRecords()
    {
        return $this->hasMany(View::class);
    }

    public function likesOrDislikes()
    {
        return $this->hasMany(LikeOrDislike::class);
    }

    public function likes()
    {
        return $this->hasMany(LikeOrDislike::class)->where('value', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(LikeOrDislike::class)->where('value', -1);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->dislikes()->count();
    }

    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }
}
