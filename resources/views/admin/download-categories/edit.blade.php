@extends('layouts.admin')

@section('title', 'Modifier une categorie')
@section('page-title', 'Modifier la categorie')
@section('page-description', 'Modification de la categorie : ' . $downloadCategory->name)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.download-categories.update', $downloadCategory) }}">
        @method('PUT')
        @include('admin.download-categories.partials.form', [
            'submitLabel' => 'Mettre Ã jour la categorie',
            'category' => $downloadCategory
        ])
    </form>
</div>
@endsection