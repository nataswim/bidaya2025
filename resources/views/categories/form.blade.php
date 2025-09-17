<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}">
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}">
    @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Groupe</label>
    <input type="text" name="group_name" class="form-control" value="{{ old('group_name', $category->group_name ?? '') }}">
    @error('group_name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="text" name="image" class="form-control" value="{{ old('image', $category->image ?? '') }}">
    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Title</label>
    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $category->meta_title ?? '') }}">
    @error('meta_title') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Description</label>
    <textarea name="meta_description" class="form-control">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
    @error('meta_description') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Meta Keywords</label>
    <textarea name="meta_keywords" class="form-control">{{ old('meta_keywords', $category->meta_keywords ?? '') }}</textarea>
    @error('meta_keywords') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Ordre</label>
    <input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? '') }}">
    @error('order') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Statut</label>
    <select name="status" class="form-select">
        <option value="active" {{ old('status', $category->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $category->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="text-danger">{{ $message }}</div> @enderror
</div>
