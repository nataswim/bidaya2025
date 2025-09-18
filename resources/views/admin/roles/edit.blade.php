@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le rôle</h1>

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf @method('PUT')
        @include('roles.partials.form', ['role' => $role])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
