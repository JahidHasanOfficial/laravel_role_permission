<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{


    public static function middleware() : array
    {
        return [
             new Middleware('permission:view posts', only: ['index']),
            new Middleware('permission:create posts', only: ['create']),
            new Middleware('permission:update posts', only: ['edit']),
            new Middleware('permission:delete posts', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->get();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|min:3|max:255',
            'description' => 'required',
            'author' => 'required',
        ]);

        if ($validator->passes()) {
            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'author' => $request->author,
            ]);

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } else {
            return redirect()->route('posts.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $post = Post::findOrFail($id);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'description' => 'required',
            'author' => 'required',
        ]);

        if ($validator->passes()) {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->author = $request->author;
            $post->save();
            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } else {
            return redirect()->route('posts.edit', $id)->withInput()->withErrors($validator);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
