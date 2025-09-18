@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des tags</h1>

    <form method="GET" action="{{ route('tags.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par nom...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('tags.create') }}" class="btn btn-success mb-3">+ Nouveau tag</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>
                        <a href="{{ route('tags.show', $tag) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce tag ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Aucun tag trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $tags->links() }}
</div>
@endsection
