@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon profil</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>Nom complet</th><td>{{ $user->first_name }} {{ $user->last_name }}</td></tr>
        <tr><th>Nom d'utilisateur</th><td>{{ $user->username }}</td></tr>
        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
        <tr><th>Rôle</th><td>{{ $user->role->display_name ?? '-' }}</td></tr>
        <tr><th>Bio</th><td>{{ $user->bio }}</td></tr>
        <tr><th>Téléphone</th><td>{{ $user->phone }}</td></tr>
        <tr><th>Date de naissance</th><td>{{ $user->date_of_birth }}</td></tr>
        <tr><th>Langue</th><td>{{ $user->locale }}</td></tr>
        <tr><th>Fuseau horaire</th><td>{{ $user->timezone }}</td></tr>
    </table>

    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Modifier</a>
</div>
@endsection
