@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier mon profil</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PUT')
        @include('profile.partials.form', ['user' => $user])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-3">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer votre compte ?')">Supprimer mon compte</button>
    </form>
</div>
@endsection
