@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-2">Modifier la catégorie</h1>
        <p class="text-muted">{{ $exerciceCategory->name }}</p>
    </div>

    <form method="POST" action="{{ route('admin.exercice-categories.update', $exerciceCategory) }}">
        @method('PUT')
        @include('admin.exercice-categories.partials.form', [
            'submitLabel' => 'Mettre à jour',
            'exerciceCategory' => $exerciceCategory
        ])
    </form>
</div>
@endsection