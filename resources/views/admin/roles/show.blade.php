@extends('layouts.admin')

@section('title', 'Détails du rôle')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Détails du rôle</h1>

    <div class="bg-white p-6 rounded shadow-md">
        <p><strong>Nom :</strong> {{ $role->name }}</p>
        <p><strong>Description :</strong> {{ $role->description }}</p>
        <p><strong>Date de création :</strong> {{ $role->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('roles.edit', $role) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('roles.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Retour
        </a>
    </div>
@endsection
