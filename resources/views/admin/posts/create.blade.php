@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un article</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('posts.partials.form', ['post' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
