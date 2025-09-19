@extends('layouts.admin')

@section('title', 'Créer une permission')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Créer une nouvelle permission</h1>

    <form action="{{ route('permissions.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @include('admin.permissions.partials.form', ['submitLabel' => 'Créer'])
    </form>
@endsection
