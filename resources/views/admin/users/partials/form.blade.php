@csrf

<div class="mb-4">
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
                  :value="old('name', $user->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" name="email" type="email" class="block mt-1 w-full"
                  :value="old('email', $user->email ?? '')" required />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

@if(!isset($user))
    <div class="mb-4">
        <x-input-label for="password" :value="__('Mot de passe')" />
        <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" required />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
@endif

<div class="mb-4">
    <x-input-label for="role" :value="__('Rôle')" />
    <select id="role" name="role" class="border-gray-300 rounded-md shadow-sm w-full">
        <option value="user" @selected(old('role', $user->role ?? '') === 'user')>Utilisateur</option>
        <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>Administrateur</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

<div class="flex justify-end">
    <x-primary-button>
        {{ $submitLabel ?? 'Enregistrer' }}
    </x-primary-button>
</div>
