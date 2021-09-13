<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        $fillName = null;
        if($request->hasFile('image'))
           //dd($request->file('image'));
            $path = $request->file('image')
                ->storeAs('public/images', $request->file('image')->getClientOriginalName());
                //dd($path);

        $input = array_merge($request->all(),
            ["user_id"=>Auth::user()->id]);

            // mass assignment
            // eloquent model의 white list인 $fillable에 기술해야 한다.
        if($path) {
            //dd($path,':'.strrpos($path, '/'));
            $path = substr($path, strrpos($path, '/')+1);
            //dd($path);
            $path = time().'_'.$path;

            $input = array_merge($input, ['image' => $path]);
            dd($input);
        }
            
        Post::create($input);

        // $post = new Post;
        // $post->title = $input['title'];
        // $post->content = $input['content'];

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
