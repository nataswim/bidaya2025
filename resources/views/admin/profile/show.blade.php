@extends('layouts.admin')

@section('title', 'Mon profil')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Mon profil</h1>

    <div class="bg-white p-6 rounded shadow-md space-y-4">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Date de creation :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Modifier mon profil
        </a>
    </div>
@endsection
