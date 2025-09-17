@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'utilisateur</h1>

    <table class="table table-bordered">
        <tr><th>Nom</th><td>{{ $user->name }}</td></tr>
        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
        <tr><th>Rôle</th><td>{{ $user->role->display_name ?? '-' }}</td></tr>
        <tr><th>Statut</th><td>{{ $user->status }}</td></tr>
        <tr><th>Bio</th><td>{{ $user->bio }}</td></tr>
        <tr><th>Téléphone</th><td>{{ $user->phone }}</td></tr>
               <tr><th>Date de naissance</th><td>{{ $user->date_of_birth }}</td></tr>
        <tr><th>Langue</th><td>{{ $user->locale }}</td></tr>
        <tr><th>Fuseau horaire</th><td>{{ $user->timezone }}</td></tr>
        <tr><th>Avatar</th>
            <td>
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="Avatar" style="max-height:80px;">
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
