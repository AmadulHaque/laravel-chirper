<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\SendEmail;
use App\Jobs\SendOtpJob;
use App\Jobs\SendMailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
      // $post =  Post::where('description','!=',null)->cursorPaginate(5);

        // return $post;
        // Benchmark::dd([
        //     'Eloquent ORM' => fn () => Post::where('description','!=',null)->get(),
        //     'Query Builder' => fn () => DB::table('posts')->where('description','!=',null)->get(),
        // ]);


        // $post = Post::first();
        // return $post->getTranslations('description')['bn'];
        return view('posts.index',[
            'posts' => Post::with('user')->latest()->paginate(5),
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
        $post = Post::create($data);
        if ($request->image) {
            $post->addMedia($request->image)
            ->usingFileName($file_name . '-post.jpg')
            ->toMediaCollection('post_image');
        }
        for($i=1; $i <= 500; $i++ ){
            dispatch(new SendMailJob((object) $request->all()));
        }

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
    public function sendOtp()
    {
        dispatch(new SendOtpJob(null))->onQueue('high');
        return redirect(route('posts.index'));
    }
}
