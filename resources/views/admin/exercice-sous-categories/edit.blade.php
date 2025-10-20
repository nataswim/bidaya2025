@extends('layouts.admin')

@section('title', 'Modifier la sous-catégorie')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-2">Modifier la sous-catégorie</h1>
        <p class="text-muted">{{ $exerciceSousCategory->name }}</p>
    </div>

    <form method="POST" action="{{ route('admin.exercice-sous-categories.update', $exerciceSousCategory) }}">
        @method('PUT')
        @include('admin.exercice-sous-categories.partials.form', [
            'submitLabel' => 'Mettre à jour',
            'exerciceSousCategory' => $exerciceSousCategory
        ])
    </form>
</div>
@endsection