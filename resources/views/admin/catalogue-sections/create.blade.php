@extends('layouts.admin')

@section('title', 'Créer une Section')
@section('page-title', 'Nouvelle Section du Catalogue')
@section('page-description', 'Création d\'une nouvelle section')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-sections.store') }}">
        @include('admin.catalogue-sections.partials.form', [
            'submitLabel' => 'Créer la section'
        ])
    </form>
</div>
@endsection