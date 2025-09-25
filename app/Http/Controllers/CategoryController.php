<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
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
        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie creee avec succes.');
    }

    public function show(Category $category)
    {
        $this->checkAdminAccess();
        
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->checkAdminAccess();
        
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        $data['updated_by'] = auth()->id();
        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie mise Ã jour avec succes.');
    }

    public function destroy(Category $category)
    {
        $this->checkAdminAccess();
        
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer une categorie avec des articles.');
        }
        
        $category->update(['deleted_by' => auth()->id()]);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categorie supprimee avec succes.');
    }
}