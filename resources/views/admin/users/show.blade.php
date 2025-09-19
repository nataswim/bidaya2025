@extends('layouts.admin')

@section('title', 'Détails utilisateur')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Détails de l’utilisateur</h1>

    <div class="bg-white p-6 rounded shadow-md">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Rôle :</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Date de création :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Retour
        </a>
    </div>
@endsection
