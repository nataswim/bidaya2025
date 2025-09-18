@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'article</h1>

    <table class="table table-bordered">
        @foreach($post->getAttributes() as $field => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>

    <h3>Catégorie</h3>
    <p>{{ $post->category->name ?? '-' }}</p>

    <h3>Tags</h3>
    <ul>
        @forelse($post->tags as $tag)
            <li>{{ $tag->name }}</li>
        @empty
            <li>Aucun tag</li>
        @endforelse
    </ul>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
