@extends('layouts.public')

@section('title', 'Bienvenue')

@section('content')
    <div class="text-center py-12">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur Bidaya 2025</h1>
        <p class="mb-6">Une plateforme moderne pour gÃ©rer et partager vos contenus.</p>
        <a href="{{ route('about') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            En savoir plus
        </a>
    </div>
@endsection
