@csrf

<div class="mb-4">
    <x-input-label for="name" :value="__('Nom de la permission')" />
    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
                  :value="old('name', $permission->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" rows="3"
              class="border-gray-300 rounded-md shadow-sm w-full">{{ old('description', $permission->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="flex justify-end">
    <x-primary-button>
        {{ $submitLabel ?? 'Enregistrer' }}
    </x-primary-button>
</div>
