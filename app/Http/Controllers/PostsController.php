<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
            1. 게시글 리스트를 DB에서 읽어온다
            2. 게시글 목록을 만들어주는 blade에 읽어온 데이터를 표시
        */

        // select * from posts
       // $posts = Post::all();
        //$posts = Post::orderBy('created_at', 'desc')->get();

        //$posts = Post::latest()->get();
        //$posts = Post::oldest()->get();

        $posts = Post::latest()->paginate(10);
        //dd($posts);
        return view('bbs.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bbs.create');

}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required', 
                        'content'=>'required|min:3']);
        
        $fileName = null;
        if($request->hasFile('image')) {
            // dd($request->file('image'));
            $fileName = time().'_'.
                $request->file('image')->getClientOriginalName();
            $path = $request->file('image')  
                ->storeAs('public/images', $fileName);
            // dd($path);
        }                       
        //
        // dd($request->all());
        $input = array_merge($request->all(), 
                ["user_id"=>Auth::user()->id]);
        // 이미지가 있으면.. $input에 image 항목 추가
        if($fileName) {

            $input = array_merge($input, ['image' => $fileName]);
            // dd($input);
        }
         /*
            $request->all() : ['title'=>'dfakl', 'content'=>'cdkd']
            ["user_id"=>Auth::user()->id] => ['user_id'=>1]
        arrary_merge(['title'=>'dfakl', 'content'=>'cdkd'], 
                            ['user_id'=>1])

         */
        // dd($input);
        /*
            $input의 내용은 
                ["title"=>"dasjfl", "content=>"cdajl", "user_id"=>1]

        */

        // mass assignment 
        // Eloquent model의 white list 인 $fillable에 기술해야 한다.
        Post::create($input);

        // $post = new Post;
        // $post->title = $input['title'];
        // $post->content = $input['content'];

        // ... 

        // $post->save();
        
        // return view('bbs.index', ['posts'=>Post::all()]);
        return redirect()->route('posts.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $id에 해당하는 Post를 DB에서 인출하고 그 것을 상세보기 뷰로 전달한다.
        $post = Post::find($id);
        return view('bbs.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id에 해당하는 포스트를 수정할 수 있는
        // 페이지를 반환해주면 된다
        

        return view('bbs.edit', ['post'=>Post::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title'=> 'required',
        'content'=>'required|min:3']);

        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;

        //이 이미지를 이 게시글의 이미지로 변경하겠다는 의미.
        if($request->image) {
            //이 이미지를 이 게시글의 이미지로 파일 시스템에
            // 저장하고, DB에 반영하기 전에
            // 기존 이미지가 있다면
            // 그 이미지를 파일 시스템에서 삭제해줘야 한다.
            if($post->image) {
                Storage::delete('public/images/'.$post->image);
            }
            $fileName = time().'_'.
                $request->file('image')->getClientOriginalName();
                $post->image = $fileName;
                $request->image->storeAs('public/images', $fileName);
        }
        $post->save();
        /* update posts set title = $request->title,
                        content = $request->content,
                        image = $fileName
                        updated_at = now(),
            where id = $id;
        */


        // $post->update(['title'=>$request->title,
        //                     'content'=>$request->content]);
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //DI, Dependency Injection, 의존성 주입
        //dd($request);
        $post = Post::find($id);

        //게시글에 딸린 이미지가 있으면 파일시스템에서도 삭제해줘야함
        if($post->image) {
            Storage::delete('public/images/'.$post->image); 
        }
        
        $post->delete();

        return redirect()->route('posts.index');
    }

    public function deleteImage($id) {
        $post = Post::find($id);
        // dd($post);
        Storage::delete('public/images', $post->image);
        $post->image = null;
        $post->save();

        return redirect()->route('posts.edit', ['post'=>$post->id]);
    }
}
