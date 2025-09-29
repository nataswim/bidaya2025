@extends('layouts.admin')

@section('title', 'Créer une fiche')
@section('page-title', 'Nouvelle fiche')
@section('page-description', 'Création d\'une nouvelle fiche')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.fiches.store') }}">
        @include('admin.fiches.partials.form', [
            'submitLabel' => 'Créer la fiche',
            'categories' => $categories
        ])
    </form>
</div>
@endsection