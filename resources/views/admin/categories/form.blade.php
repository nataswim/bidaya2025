@extends('layouts.admin')

@section('title', $category->exists ? 'Modifier une catégorie' : 'Créer une catégorie')

@section('content')
    <h1 class="text-2xl font-bold mb-6">
        {{ $category->exists ? 'Modifier la catégorie : ' . $category->name : 'Créer une nouvelle catégorie' }}
    </h1>

    <form action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @if($category->exists)
            @method('PUT')
        @endif
        @include('admin.categories.partials.form', [
            'submitLabel' => $category->exists ? 'Mettre à jour' : 'Créer',
            'category' => $category
        ])
    </form>
@endsection
