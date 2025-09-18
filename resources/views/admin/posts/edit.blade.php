@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'article</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf @method('PUT')
        @include('posts.partials.form', ['post' => $post])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
