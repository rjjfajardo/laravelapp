<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;

class PostsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //return Post::all();
        // return view('posts.index');
         
        // $posts = DB::select('SELECT * FROM posts');         // SQL QUERY
       //$posts = Post::orderBy('title', 'desc')->take(1)->get();  //ELOQUENT QUERY
        //$posts = Post::orderBy('title', 'desc')->get();
        
        $posts = Post::orderBy('created_at', 'desc')->paginate(1);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
              'title' => 'required',
              'body' => 'required',
              'cover_img' => 'image|nullable|max:1999|required'
        ]);
        
      
        //Handle file upload
       if($request->hasFile('cover_img')){
        //Get filename w/ extension
        $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
        //get just filename
         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //get just extensions
        $extension = $request->file('cover_img')->getClientOriginalExtension();
        //filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //upload iamge
        $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);
   }else{
       $fileNameToStore = 'noimage.jpeg';
   }
      // Create Post

      $post = new Post;
      $post->title = $request->input('title');
      $post->body = $request->input('body');
      $post->user_id = auth()->user()->id;
      $post->cover_img = $fileNameToStore;
      $post->save();


        return redirect('/posts')->with('success', 'Post Created');
    }
        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user to to do some action
        if(auth()->user()->id !==$post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorized Access');    
        }
        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
      ]);

         //Handle file upload
         if($request->hasFile('cover_img')){
            //Get filename w/ extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            //get just filename
             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just extensions
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload iamge  
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);
      
         }
      // Create Post

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body'); 
        
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);


        if(auth()->user()->id !==$post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorized Access');    
        }
        if($post->cover_img != 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_img);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
