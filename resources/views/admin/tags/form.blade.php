@extends('layouts.admin')

@section('title', $tag->exists ? 'Modifier un tag' : 'Créer un tag')

@section('content')
    <h1 class="text-2xl font-bold mb-6">
        {{ $tag->exists ? 'Modifier le tag : ' . $tag->name : 'Créer un nouveau tag' }}
    </h1>

    <form action="{{ $tag->exists ? route('tags.update', $tag) : route('tags.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @if($tag->exists)
            @method('PUT')
        @endif
        @include('admin.tags.partials.form', ['submitLabel' => $tag->exists ? 'Mettre à jour' : 'Créer', 'tag' => $tag])
    </form>
@endsection
