@extends('layouts.admin')

@section('title', 'Modifier un rôle')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier le rôle : {{ $role->name }}</h1>

    <form action="{{ route('roles.update', $role) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.roles.form', ['submitLabel' => 'Mettre à jour', 'role' => $role])
    </form>
@endsection
