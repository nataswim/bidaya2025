<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Tag::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $tags = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('tags.index', compact('tags', 'search'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()->route('tags.index')
            ->with('success', 'Tag créé avec succès.');
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return redirect()->route('tags.index')
            ->with('success', 'Tag mis à jour avec succès.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag supprimé avec succès.');
    }
}
