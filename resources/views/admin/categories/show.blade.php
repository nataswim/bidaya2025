@extends('layouts.admin')

@section('title', 'Détails de la catégorie')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Détails de la catégorie</h1>

    <div class="bg-white p-6 rounded shadow-md">
        <p><strong>Nom :</strong> {{ $category->name }}</p>
        <p><strong>Slug :</strong> {{ $category->slug }}</p>
        <p><strong>Description :</strong> {{ $category->description }}</p>
        <p><strong>Date de création :</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Retour
        </a>
    </div>
@endsection
