<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Egulias\EmailValidator\Warning\Comment as WarningComment;
use Illuminate\Http\Request;
use PhpParser\Comment as PhpParserComment;

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
        $comments = Comment::with('user')->where('postd', $postId)
                        ->latest()->paginate(2);
        //$comment = Comment::find($comment_id);
        return $comments;
    }

    //댓글 등록
    public function store(Request $request, $postId) {
        /* Comment 객체를 생성하고,
         이 객체의 멤버변수(프로퍼티)를 설정하고
            save();
            두 번째 방법 :
          Comment::create([]);
         */
        $request->validate(['comment'=>'required']);
        //$request->validate(['email'=>'required|email']);
        // $this->validate($request, ['comment' => 'required']);

        // create에 사용할 수 있는 칼럼들은
        // Eloquent 모델 클래스에 
        // pro$fillable에 명시되어 있어야 한다.

        $comment = Comment::Create([
            'comment'=> $request->input('comment'),
            'user_id'=> auth()->user()->id, //로그인한 사용자의 id
            'post_id'=> $postId, 
        ]);

        return $comment; //위 creatae에 의해 삽입된 레코드에 대응된 Eloquent
    }

    public function update(Request $request, $commentId) {
        
        $request->validate(['comment'=>'required']);
        // update할 레코드를 먼저 찾고, 그 다음 update
        // select * from comments where id?
        $comment = Comment::find($commentId);
        // update comments set comment=? where id = ?
        $comment->update([
            'comment'=> $request->input('comment')
        ]);
        return $comment;
    }

    public function destroy($comment_id) {
        /*
            comments 테이블에서 id가 $commentId인 레코드를 삭제
            1. RAW query
            2. DB Query Builder
            3. Eloquent
        */
        
        // select from comments where id = ?
        $comment = Comment::find($comment_id);

       // delete from comments where id = ?
        $comment->delete();

        return $comment;
    }
}
