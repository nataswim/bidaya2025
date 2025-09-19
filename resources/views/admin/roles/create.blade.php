@extends('layouts.admin')

@section('title', 'Créer un rôle')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Créer un nouveau rôle</h1>

    <form action="{{ route('roles.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @include('admin.roles.form', ['submitLabel' => 'Créer'])
    </form>
@endsection
