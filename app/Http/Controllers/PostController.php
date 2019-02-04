<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$post = Post::all();
        //$post = Post::where('title', 'Objava 1')->get();
        //$posts = Post::orderBy('created_at', 'asc')->take(1)->get();
        //$posts = Post::orderBy('created_at', 'asc')->paginate(10);
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request,
        [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        //Nalaganje slik
        if($request->hasFile('cover_image'))
        {
            //Shrani ime slike z končnico
            $filenamewithExt = $request->file('cover_image')->getClientOriginalName();

            //Shrani samo ime slike
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);

            //Shrani samo končnico slike
            $extension = $request->file('cover_image')->guessClientExtension();

            //Shrani unikato ime slike
            $fileNameToStore = time().'_'.$filename.'.'.$extension;
            //$fileNameToStore = time().'.'.$extension;

            //Naloži sliko
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'noimage.jpg';
        }

        //Ustvari objavo
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Objava uspešno ustvarjena');
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

        //Preveri ali je uporabnik ustrezen
        if (auth()->user()->id == $post->user_id) {
            return view('posts.edit')->with('post', $post);
        }
        else {
            return redirect('posts')->with('error', 'Nimate dostopa do urejanja objave!');
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
        $this->validate($request,
        [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        //Nalaganje slik
        if($request->hasFile('cover_image'))
        {
            //Shrani ime slike z končnico
            $filenamewithExt = $request->file('cover_image')->getClientOriginalName();

            //Shrani samo ime slike
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);

            //Shrani samo končnico slike
            $extension = $request->file('cover_image')->guessClientExtension();

            //Shrani unikato ime slike
            $fileNameToStore = time().'_'.$filename.'.'.$extension;
            //$fileNameToStore = time().'.'.$extension;

            //Naloži sliko
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        //Update post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image'))
        {
            //Storage::delete('public/cover_images' . $post->cover_image);
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Objava uspešno urejena');
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


        //Preveri ali je uporabnik ustrezen.
        if (auth()->user()->id == $post->user_id) {

            //Briši komentarje
            app('App\Http\Controllers\CommentsController')->destroy($post);

            $post->delete();


            //$this->reactions->each->delete();
            return redirect('/posts')->with('success', 'Objava izbrisana');
        }
        else {
            return redirect('posts')->with('error', 'Nimate dostopa do brisanja objave!');
        }

    }

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
}
