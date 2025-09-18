@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des articles</h1>

    <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par titre...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">+ Nouvel article</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Publié le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->category->name ?? '-' }}</td>
                    <td>{{ $post->status }}</td>
                    <td>{{ $post->published_at }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun article trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $posts->links() }}
</div>
@endsection
