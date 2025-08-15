<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    //

    protected $fillable=[
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'published_at',
        'user_id'
    ];
    protected $casts=[
        'published_at'=>'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($post){
            if (empty($post->slug)) {
                $post->slug=Str::slug($post->title);
            }
        }
    );
    }

    //user model relation
    public function user(){
        return $this->belongsTo(User::class);
    }

    //comment model relation
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //retirving only approved comments
  public function approvedComments(){
    return $this->hasMany(Comment::class)->where('is_approved', true);
}
    //like model relation
    public function likes(){
        return $this->hasMany(Like::class);
    }
    //like by what user , taking userid
    public function isLikedBy(?User $user) {
    if (!$user) return false;
    return $this->likes()->where('user_id', $user->id)->exists();
}

    public function scopePublished($query)  {
        return $query->where('status','published')->where('published_at','<=',now());
    }
}
