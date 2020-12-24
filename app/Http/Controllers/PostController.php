<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('profile.user.friends')->orderBy('created_at', 'desc')->get();

        return $posts;
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
        $profile = Profile::findOrFail($request->profile_id);

        if ($request->img) {
            $exploded = explode(',', $request->img);
            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }

            $fileName = Str::random() . '.' . $extension;

            $path = public_path() . '/img/' . $fileName;

            file_put_contents($path, $decoded);

            $post = $profile->posts()->create([
                'img' => $fileName,
                'description' => $request->description
            ]);

            $image = Image::make(public_path('img/') . $post->img)->fit(800, 600);
            $image->save();
        } else {
            $post = $profile->posts()->create([
                'description' => $request->description
            ]);
        }

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->profile->user->friends;

        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($request->img) {
            $exploded = explode(',', $request->img);
            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png';
            }

            $fileName = Str::random() . '.' . $extension;

            $path = public_path() . '/img/' . $fileName;

            file_put_contents($path, $decoded);

            $post->update([
                'img' => $fileName,
                'description' => $request->description
            ]);

            $image = Image::make(public_path('img/') . $post->img)->fit(800, 600);
            $image->save();
        } else {
            $post->update([
                'description' => $request->description
            ]);
        }

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $post;
    }
}
