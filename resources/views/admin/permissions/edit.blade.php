@extends('layouts.admin')

@section('title', 'Modifier une permission')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier la permission : {{ $permission->name }}</h1>

    <form action="{{ route('permissions.update', $permission) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @method('PUT')
        @include('admin.permissions.partials.form', ['submitLabel' => 'Mettre à jour', 'permission' => $permission])
    </form>
@endsection
