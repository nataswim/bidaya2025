@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier l’utilisateur : {{ $user->name }}</h1>

    <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.users.partials.form', ['submitLabel' => 'Mettre à jour', 'user' => $user])
    </form>
@endsection
