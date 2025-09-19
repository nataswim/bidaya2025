@extends('layouts.admin')

@section('title', 'Modifier un tag')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier le tag : {{ $tag->name }}</h1>

    <form action="{{ route('tags.update', $tag) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.tags.partials.form', ['submitLabel' => 'Mettre à jour', 'tag' => $tag])
    </form>
@endsection
