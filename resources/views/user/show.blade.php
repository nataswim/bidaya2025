@extends('layouts.user')

@section('title', 'Détails utilisateur')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Profil de {{ $user->name ?? 'Utilisateur' }}</h1>

    <p><strong>Email :</strong> {{ $user->email ?? '' }}</p>
    <p><strong>Date d’inscription :</strong> {{ $user->created_at ?? '' }}</p>

    <a href="{{ route('user.index') }}" class="text-blue-600 hover:underline mt-4 inline-block">← Retour à la liste</a>
@endsection
