@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'utilisateur</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        @include('users.partials.form', ['user' => $user])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
