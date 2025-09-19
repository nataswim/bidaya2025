@extends('layouts.admin')

@section('title', 'Modifier une catégorie')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier la catégorie : {{ $category->name }}</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.categories.partials.form', ['submitLabel' => 'Mettre à jour', 'category' => $category])
    </form>
@endsection
