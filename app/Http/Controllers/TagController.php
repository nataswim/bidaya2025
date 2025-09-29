<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Acces non autorise');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $query = Tag::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('group_name', 'like', "%{$search}%");
            });
        }

        $tags = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.tags.index', compact('tags', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag cree avec succes.');
    }

    public function show(Tag $tag)
    {
        $this->checkAdminAccess();
        
        $tag->load('posts');
        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->checkAdminAccess();
        
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['updated_by'] = auth()->id();
        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag mis A jour avec succes.');
    }

    public function destroy(Tag $tag)
    {
        $this->checkAdminAccess();
        
        // Verifier les dependances avec les posts
        if ($tag->posts()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'Impossible de supprimer un tag utilise par des articles.');
        }
        
        $tag->update(['deleted_by' => auth()->id()]);
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag supprime avec succes.');
    }
}