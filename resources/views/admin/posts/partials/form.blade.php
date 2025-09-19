@csrf

<div class="mb-4">
    <x-input-label for="title" :value="__('Titre')" />
    <x-text-input id="title" name="title" type="text" class="block mt-1 w-full"
                  :value="old('title', $post->title ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="block mt-1 w-full"
                  :value="old('slug', $post->slug ?? '')" required />
    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="content" :value="__('Contenu')" />
    <textarea id="content" name="content" rows="6"
              class="border-gray-300 rounded-md shadow-sm w-full">{{ old('content', $post->content ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="category_id" :value="__('Catégorie')" />
    <select id="category_id" name="category_id" class="border-gray-300 rounded-md shadow-sm w-full">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="tags" :value="__('Tags')" />
    <select id="tags" name="tags[]" multiple class="border-gray-300 rounded-md shadow-sm w-full">
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}" @selected(collect(old('tags', $post->tags->pluck('id') ?? []))->contains($tag->id))>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
</div>

<div class="flex justify-end">
    <x-primary-button>
        {{ $submitLabel ?? 'Enregistrer' }}
    </x-primary-button>
</div>
