<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $posts = Post::paginate(6);
        return response()->json([
            'success'=> true,
            'result' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // dd($slug);
        $post = Post::where('slug', $slug)->with(['category', 'tags'])->first();

        if($post->cover){
            $post->cover = url('storage/' . $post->cover);
        }

        return response()->json([
            'success' => true,
            'result' => $post
        ]);

    }
}
