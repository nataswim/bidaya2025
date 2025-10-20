@extends('layouts.admin')

@section('title', 'Créer une catégorie d\'exercice')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-2">Créer une catégorie d'exercice</h1>
        <p class="text-muted">Ajoutez une nouvelle catégorie pour organiser vos exercices</p>
    </div>

    <form method="POST" action="{{ route('admin.exercice-categories.store') }}">
        @include('admin.exercice-categories.partials.form', [
            'submitLabel' => 'Créer la catégorie'
        ])
    </form>
</div>
@endsection