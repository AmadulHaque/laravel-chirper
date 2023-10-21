<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // $post = Post::first();
        // return $post->getTranslations('description')['bn'];
        return view('posts.index',[
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [];
        $data['description'] =  [
            'en' => $request->description_en,
            'bn' => $request->description_bn
        ];
        $data['user_id'] = $request->user()->id;
        $file_name = Str::random(20);
        Post::create($data)
        ->addMedia($request->image)
        ->usingFileName($file_name . '-post.jpg')
        ->toMediaCollection('post_image');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = array();
        $data['description'] =  [
            'en' => $request->description_en,
            'bn' => $request->description_bn
        ];
        $data['user_id'] = $request->user()->id;
        $post->update($data);
        if($request->has('image') && $request->image != null){
            $post->clearMediaCollection('post_image');
            $file_name = $post->id . Str::random(20);
            $post->addMedia($request->image)->usingFileName($file_name . '-post.jpg')->toMediaCollection('post_image');
        }
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('posts.index'));
    }
}
