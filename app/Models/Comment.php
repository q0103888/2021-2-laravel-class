<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

   // whitelist
   protected $fillable = [
    'comment',
    'user_id',
    'post_id',
];

// blacklist
// protected $guarded = [' ', ' ', ...];

// http://localhost:8000/post/{id}/comments
// public function index_test(Post $post) {
//     //select * from comments where post_id = $post->id;
//      // Post 클래스에 comments 함수가 구현된 경우.
//     return $post->comments;
// }

    // User - Comment ( 1 : N )

    public function user() {
        // Comment 입장에서 연결된 User 를 찾을 때 belongsTo 관계 메서드 이용.

        return $this->belongsTo(User::class, 'user_id', 'id', 'users');

        /*
            SELECT * FROM USERS
            WHERE id = $this.user_id;
        */
    }

    //public function comments() {
        //return $this->belongsToMany(Comment::class, 'post_id')->latest()->get();
    //}
}