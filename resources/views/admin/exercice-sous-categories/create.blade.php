@extends('layouts.admin')

@section('title', 'Créer une sous-catégorie d\'exercice')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-2">Créer une sous-catégorie d'exercice</h1>
        <p class="text-muted">Ajoutez une nouvelle sous-catégorie pour affiner l'organisation</p>
    </div>

    <form method="POST" action="{{ route('admin.exercice-sous-categories.store') }}">
        @include('admin.exercice-sous-categories.partials.form', [
            'submitLabel' => 'Créer la sous-catégorie'
        ])
    </form>
</div>
@endsection