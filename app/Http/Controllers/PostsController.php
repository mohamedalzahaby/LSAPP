<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Posts;

class PostsController extends Controller
{
    private $imagesFolderRoutes;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->imagesFolderRoutes = 'public/cover_images';
        $this->middleware('auth' , ['except' => ['index' , 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Posts::where('title' , 'post two')->get();
        // $posts = Posts::orderBy('title','asc')->take(1)->get();
        // $posts = Posts::orderBy('title','asc')->paginate(1);
        $posts = Posts::all();
        return view('posts.index')->with('posts' , $posts);
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
        $coverimage = 'cover_image';
        $this->validate($request ,[
            'title' => 'required',
            'body' => 'required',
            $coverimage => 'image|nullable|max:1999'
            ]);
        // check if file is selected
        if ($request->hasFile($coverimage)) {
            # get file name with extension
            $filenameWithExt = $request->file($coverimage)->getClientOriginalName();
            //get just filename
            $filename =pathinfo($filenameWithExt , PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file($coverimage)->getClientOriginalExtension();//get extension
            //fileNameToStore
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload
            $path = $request->file($coverimage)->storeAs('public/cover_images',$fileNameToStore);

        }
        else {
            $fileNameToStore ='noimage.jpg';
        }
        $post = new Posts();
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $post->user_id  = auth()->user()->id;
        $post->cover_image  = $fileNameToStore;

        $post->save();
        return redirect('/posts')->with('success' , 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Posts::find($id);
        return view('posts.show')->with('posts' , $posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Posts::find($id);

        // Check for correct user
        if (auth()->user()->id !== $posts->user_id) {
            return redirect('/posts')->with('error' , 'Unauthorized Page');
        }
        else{
            return view('posts.edit')->with('posts' , $posts);
        }

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
        $coverimage = 'cover_image';
        $post = Posts::find($id);
        $this->validate($request ,[
            'title' => 'required',
            'body' => 'required'
            ]);

        if ($request->hasFile($coverimage))
        {
            # get file name with extension
            $filenameWithExt = $request->file($coverimage)->getClientOriginalName();
            //get just filename
            $filename =pathinfo($filenameWithExt , PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file($coverimage)->getClientOriginalExtension();//get extension
            //fileNameToStore
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload
            $path = $request->file($coverimage)->storeAs('public/cover_images',$fileNameToStore);
            $post->cover_image  = $fileNameToStore;
        }


        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $post->save();
        return redirect('/posts')->with('success' , 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error' , 'Unauthorized Page');
        }


        if ($post->cover_Image != 'noimage.jpg') {
            $imageRoute =  $this->imagesFolderRoutes.'/'.$post->cover_Image;
            Storage::delete( $imageRoute );
        }
        $post->delete();
        return redirect('/posts')->with('success' , 'Post Deleted');



    }
}
