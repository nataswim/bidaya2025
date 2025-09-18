<div class="mb-3">
    <label class="form-label">Nom d'utilisateur</label>
    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}">
    @error('username') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Prénom</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name ?? '') }}">
    @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name ?? '') }}">
    @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nom complet</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}">
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Mot de passe @if(isset($user)) (laisser vide pour ne pas changer) @endif</label>
    <input type="password" name="password" class="form-control">
    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Confirmer le mot de passe</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Rôle</label>
    <select name="role_id" class="form-select">
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->display_name ?? $role->name }}
            </option>
        @endforeach
    </select>
    @error('role_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Avatar (URL)</label>
    <input type="text" name="avatar" class="form-control" value="{{ old('avatar', $user->avatar ?? '') }}">
    @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Bio</label>
    <textarea name="bio" class="form-control">{{ old('bio', $user->bio ?? '') }}</textarea>
    @error('bio') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Téléphone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Date de naissance</label>
    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
    @error('date_of_birth') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Statut</label>
    <select name="status" class="form-select">
        <option value="active" {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>Actif</option>
        <option value="inactive" {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactif</option>
    </select>
    @error('status') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Langue</label>
    <input type="text" name="locale" class="form-control" value="{{ old('locale', $user->locale ?? '') }}">
    @error('locale') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Fuseau horaire</label>
    <input type="text" name="timezone" class="form-control" value="{{ old('timezone', $user->timezone ?? '') }}">
    @error('timezone') <div class="text-danger">{{ $message }}</div> @enderror
</div>
