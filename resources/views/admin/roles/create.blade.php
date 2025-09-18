@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un rôle</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        @include('roles.partials.form', ['role' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
