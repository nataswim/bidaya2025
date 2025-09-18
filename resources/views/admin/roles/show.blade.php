@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du rôle</h1>

    <table class="table table-bordered">
        <tr><th>Nom</th><td>{{ $role->name }}</td></tr>
        <tr><th>Slug</th><td>{{ $role->slug }}</td></tr>
        <tr><th>Nom affiché</th><td>{{ $role->display_name }}</td></tr>
        <tr><th>Description</th><td>{{ $role->description }}</td></tr>
        <tr><th>Niveau</th><td>{{ $role->level }}</td></tr>
        <tr><th>Par défaut</th><td>{{ $role->is_default ? 'Oui' : 'Non' }}</td></tr>
        <tr>
            <th>Permissions</th>
            <td>
                @foreach($role->permissions as $perm)
                    <span class="badge bg-info">{{ $perm->name }}</span>
                @endforeach
            </td>
        </tr>
    </table>

    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
