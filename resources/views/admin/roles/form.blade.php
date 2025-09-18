<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name ?? '') }}">
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $role->slug ?? '') }}">
    @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nom affiché</label>
    <input type="text" name="display_name" class="form-control" value="{{ old('display_name', $role->display_name ?? '') }}">
    @error('display_name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $role->description ?? '') }}</textarea>
    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Niveau</label>
    <input type="number" name="level" class="form-control" value="{{ old('level', $role->level ?? '') }}">
    @error('level') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_default" value="1" class="form-check-input" id="is_default"
        {{ old('is_default', $role->is_default ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_default">Rôle par défaut</label>
    @error('is_default') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Permissions</label>
    <select name="permissions[]" class="form-select" multiple>
        @foreach($permissions as $permission)
            <option value="{{ $permission->id }}"
                {{ in_array($permission->id, old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                {{ $permission->name }}
            </option>
        @endforeach
    </select>
    @error('permissions') <div class="text-danger">{{ $message }}</div> @enderror
</div>
