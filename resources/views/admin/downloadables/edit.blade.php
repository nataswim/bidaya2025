@extends('layouts.admin')

@section('title', 'Modifier un telechargement')
@section('page-title', 'Modifier le telechargement')
@section('page-description', 'Modification du telechargement : ' . $downloadable->title)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.downloadables.update', $downloadable) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.downloadables.partials.form', [
            'submitLabel' => 'Mettre Ã jour le telechargement',
            'downloadable' => $downloadable,
            'categories' => $categories
        ])
    </form>
</div>
@endsection