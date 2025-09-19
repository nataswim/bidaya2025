@extends('layouts.admin')

@section('title', 'Détails de l’article')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $post->title }}</h1>

    <div class="bg-white p-6 rounded shadow-md space-y-4">
        <p><strong>Slug :</strong> {{ $post->slug }}</p>
        <p><strong>Catégorie :</strong> {{ $post->category->name ?? '-' }}</p>
        <p><strong>Auteur :</strong> {{ $post->user->name ?? '-' }}</p>
        <p><strong>Contenu :</strong></p>
        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>
        <p><strong>Tags :</strong>
            @forelse($post->tags as $tag)
                <span class="inline-block bg-gray-200 px-2 py-1 rounded text-sm">{{ $tag->name }}</span>
            @empty
                Aucun tag
            @endforelse
        </p>
        <p><strong>Date de création :</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Retour
        </a>
    </div>
@endsection
