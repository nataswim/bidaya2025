@csrf

<div class="mb-4">
    <x-input-label for="name" :value="__('Nom du tag')" />
    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
                  :value="old('name', $tag->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="block mt-1 w-full"
                  :value="old('slug', $tag->slug ?? '')" required />
    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
</div>

<div class="flex justify-end">
    <x-primary-button>
        {{ $submitLabel ?? 'Enregistrer' }}
    </x-primary-button>
</div>
