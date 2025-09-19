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
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $query = Post::with(['category', 'tags']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('intro', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = Category::where('status', 'active')->get();
        $tags = Tag::where('status', 'active')->get();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['created_by_name'] = auth()->user()->name;
        
        // Synchroniser category_name
        if (isset($data['category_id'])) {
            $category = Category::find($data['category_id']);
            $data['category_name'] = $category?->name;
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function show(Post $post)
    {
        $this->checkAdminAccess();
        
        $post->load(['category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->checkAdminAccess();
        
        $categories = Category::where('status', 'active')->get();
        $tags = Tag::where('status', 'active')->get();
        $post->load('tags');
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['updated_by'] = auth()->id();
        
        // Synchroniser category_name
        if (isset($data['category_id'])) {
            $category = Category::find($data['category_id']);
            $data['category_name'] = $category?->name;
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $this->checkAdminAccess();
        
        $post->update(['deleted_by' => auth()->id()]);
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}