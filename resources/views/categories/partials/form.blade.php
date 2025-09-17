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
    <label class="form-label">Parent</label>
    <select name="parent_id" class="form-select">
        <option value="">-- Aucun --</option>
        @foreach($categories ?? [] as $cat)
            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('parent_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>
