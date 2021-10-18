<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    // http://localhost:8000/post/{id}/comments
    // public function index_test(Post $post) {
    //     /*
    //         select *
    //         from comments
    //         where post_id = $post->id;
    //     */
    //     // Post 클래스에 comments 함수 구현한 경우...
    //     return $post->comments;
    // }
    public function index($postId) {
        /*
            select * from comments where post_id = ?
            order by created_at desc;
        */
        $comments = Comment::where('post_id', $postId)->latest();
        return $comments;
    }
}
