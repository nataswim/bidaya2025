@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des rôles</h1>

    <form method="GET" action="{{ route('roles.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par nom...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">+ Nouveau rôle</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Slug</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->slug }}</td>
                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="badge bg-info">{{ $perm->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.show', $role) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce rôle ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aucun rôle trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $roles->links() }}
</div>
@endsection
