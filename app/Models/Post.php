<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "user_id",
    ];

    public function writer() {
        // User <-> Post의 relaationship
        // 1 : N
        // User는 hasMany posts
        // Post는 belongs to a User
        return $this->belongsTo(User::class, "user_id");
        /*
          select p.*, u.*
          from users u, posts p
          inner join on u.id = p.user_id
        */
    }
}
