<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentsController extends Controller
{
    public function index($postId) {

        /*
            select * from comments where post_id = ?
        */

        $comments = Comment::with('user')->where('post_id', $postId)->latest()->paginate(2);
        // dd($comments);
        return $comments;

    }

    // http://localhost:8000/post/{id}/comments
    public function index_test(Post $post) {

        /*
         * select *
         * from comments
         * where post_id = $post->id
         */

         // Post 클래스에 comments 함수 구현한 경우..

        return $post->comments;

    }

	public function update(Request $request, $commentId){
        //validation check
        $request->validate(['comment','required']);
        //update할 레코드를 먼저 찾고, 그다음 update
        $comment = Comment::find($commentId);

        $this->authorize('update',$comment);

        $comment::update([
            'comment' => $request->input('comment'),
    ]);

    return $comment;
    }

    public function destroy (Request $request, $commentId){
        /**
         * comments 테이블에서 id가 $commentId인 레코드를 삭제
         * 1. RAW query
         * 2. DB Query Builder
         * 3. Eloquent
         */
          // delet from comments where id = ?
        $comment = Comment::find($commentId);

        // CommentPolicy를 적용한 권한관리를 하자.
        // 즉 이 요청을 한 사용자가 이 댓글을 삭제할 수 있는지 체크하기
        if($request->user()->can('delete',$comment)){
            $comment-> delete();

        return $comment;
        } else { //로그인한 사용자가 삭제 권한이 없는 경우
            abort(403);
        };

        

    }


    public function store(Request $request, $postId){

        /** 방법1
         * Comment 객체 생성
         * 이 객체의 멤버변수(프로퍼티)설정
         * save(); 저장
         *
         * 방법2
         * Comment::create([]);
         */
        $request->validate(['comment'=>'required']);

        // create에 사용할 수 있는 칼럼들은
        // Eloquent 모델 클래스에
        // protected $fillable에 명시되어 있어야 한다.
        // mass assignment

        $comment =  Comment::create([
            'comment' => $request->input('comment'),
            'user_id' => auth()->user()->id, //로그인한 사용자의 id
            'post_id' => $postId,
        ]);

        return $comment;
    }
}
