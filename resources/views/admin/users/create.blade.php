@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Créer un nouvel utilisateur</h1>

    <form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @include('admin.users.partials.form', ['submitLabel' => 'Créer'])
    </form>
@endsection
