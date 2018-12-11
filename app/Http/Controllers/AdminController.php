<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $post = Post::find($id);
        if (auth()->user()->admin == 1) {
            return view('admin.edit')->with('post', $post);
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

        return redirect('/admin')->with('success', 'Objava uspešno urejena');
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

        //Preveri ali je uporabnik ustrezen
        if (auth()->user()->admin == 1) {
            $post->delete();
            return redirect('/admin')->with('success', 'Objava izbrisana');
        }
        else {
            return redirect('/posts')->with('error', 'Nimate dostopa do brisanja objave!');
        }
    }
}
