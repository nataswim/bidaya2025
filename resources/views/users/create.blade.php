@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un utilisateur</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users.partials.form', ['user' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
