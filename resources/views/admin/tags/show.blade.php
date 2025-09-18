@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du tag</h1>

    <table class="table table-bordered">
        <tr><th>Nom</th><td>{{ $tag->name }}</td></tr>
        <tr><th>Slug</th><td>{{ $tag->slug }}</td></tr>
        <tr><th>Description</th><td>{{ $tag->description }}</td></tr>
    </table>

    <a href="{{ route('tags.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
