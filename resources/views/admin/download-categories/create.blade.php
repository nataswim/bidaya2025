@extends('layouts.admin')

@section('title', 'Creer une categorie de telechargement')
@section('page-title', 'Nouvelle categorie')
@section('page-description', 'Creation d\'une nouvelle categorie de telechargement')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.download-categories.store') }}">
        @include('admin.download-categories.partials.form', [
            'submitLabel' => 'Creer la categorie'
        ])
    </form>
</div>
@endsection