@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des catégories</h1>

    <form method="GET" action="{{ route('categories.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par nom...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">+ Nouvelle catégorie</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Statut</th>
                <th>Ordre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->order }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune catégorie trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection
