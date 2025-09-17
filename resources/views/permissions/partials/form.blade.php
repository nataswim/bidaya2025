<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name ?? '') }}">
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $permission->slug ?? '') }}">
    @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Groupe</label>
    <input type="text" name="group" class="form-control" value="{{ old('group', $permission->group ?? '') }}">
    @error('group') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $permission->description ?? '') }}</textarea>
    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
</div>
