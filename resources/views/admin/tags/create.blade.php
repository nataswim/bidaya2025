@extends('layouts.admin')

@section('title', 'Créer un tag')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Créer un nouveau tag</h1>

    <form action="{{ route('tags.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @include('admin.tags.partials.form', ['submitLabel' => 'Créer'])
    </form>
@endsection
