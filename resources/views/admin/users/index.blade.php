@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des utilisateurs</h1>

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher par nom ou email...">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">+ Nouvel utilisateur</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name ?? $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->display_name ?? '-' }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun utilisateur trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
