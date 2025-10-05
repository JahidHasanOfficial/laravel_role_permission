<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Helpers\ImageHelper;
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
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->passes()) {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->author = $request->author;
          
            if ($request->hasFile('image')) {
                $post->image = ImageHelper::upload($request->file('image'), 'posts');
                $post->save();
            } else {
                $post->image = null;
            }
            $post->save();

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
            if ($request->hasFile('image')) {
                $post->image = ImageHelper::update($request->file('image'), $post->image, 'posts');
            }
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
        // Delete associated image
        ImageHelper::delete($post->image);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
