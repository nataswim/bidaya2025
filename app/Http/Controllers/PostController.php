<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Post::with('category', 'tags');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return redirect()->route('posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function show(Post $post)
    {
        $post->load('category', 'tags');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load('tags');
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return redirect()->route('posts.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}
