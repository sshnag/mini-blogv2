<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    use HasFactory;

    protected $fillable=[
        'content',
        'is_approved',
        'post_id',
        'user_id'
    ];

    protected $casts=[
        'is_approved'=>'boolean',
    ];

    public function post()
     {
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
