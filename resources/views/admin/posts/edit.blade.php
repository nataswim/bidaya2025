@extends('layouts.admin')

@section('title', 'Modifier un article')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier l’article : {{ $post->title }}</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.posts.partials.form', ['submitLabel' => 'Mettre à jour', 'post' => $post])
    </form>
@endsection
