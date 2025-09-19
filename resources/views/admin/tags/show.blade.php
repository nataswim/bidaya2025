@extends('layouts.admin')

@section('title', 'Détails du tag')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Détails du tag</h1>

    <div class="bg-white p-6 rounded shadow-md">
        <p><strong>Nom :</strong> {{ $tag->name }}</p>
        <p><strong>Slug :</strong> {{ $tag->slug }}</p>
        <p><strong>Date de création :</strong> {{ $tag->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('tags.edit', $tag) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('tags.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Retour
        </a>
    </div>
@endsection
