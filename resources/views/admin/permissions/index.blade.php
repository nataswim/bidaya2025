@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des permissions</h1>

    <form method="GET" action="{{ route('permissions.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par nom...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('permissions.create') }}" class="btn btn-success mb-3">+ Nouvelle permission</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Groupe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->slug }}</td>
                    <td>{{ $permission->group }}</td>
                    <td>
                        <a href="{{ route('permissions.show', $permission) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette permission ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aucune permission trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $permissions->links() }}
</div>
@endsection
