<div class="mb-3">
    <label class="form-label">Titre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $post->name ?? '') }}">
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}">
    @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Introduction</label>
    <textarea name="intro" class="form-control">{{ old('intro', $post->intro ?? '') }}</textarea>
    @error('intro') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Contenu</label>
    <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Type</label>
    <input type="text" name="type" class="form-control" value="{{ old('type', $post->type ?? '') }}">
    @error('type') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Catégorie</label>
    <select name="category_id" class="form-select">
        <option value="">-- Sélectionner --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tags</label>
    <select name="tags[]" class="form-select" multiple>
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}" 
                {{ in_array($tag->id, old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    @error('tags') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="text" name="image" class="form-control" value="{{ old('image', $post->image ?? '') }}">
    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Title</label>
    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title ?? '') }}">
    @error('meta_title') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Keywords</label>
    <textarea name="meta_keywords" class="form-control">{{ old('meta_keywords', $post->meta_keywords ?? '') }}</textarea>
    @error('meta_keywords') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Description</label>
    <textarea name="meta_description" class="form-control">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
    @error('meta_description') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Statut</label>
    <select name="status" class="form-select">
        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Brouillon</option>
        <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Publié</option>
    </select>
    @error('status') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Date de publication</label>
    <input type="date" name="published_at" class="form-control" value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d') : '') }}">
    @error('published_at') <div class="text-danger">{{ $message }}</div> @enderror
</div>
