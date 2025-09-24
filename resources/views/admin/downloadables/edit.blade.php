@extends('layouts.admin')

@section('title', 'Modifier un tÃ©lÃ©chargement')
@section('page-title', 'Modifier le tÃ©lÃ©chargement')
@section('page-description', 'Modification du tÃ©lÃ©chargement : ' . $downloadable->title)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.downloadables.update', $downloadable) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.downloadables.partials.form', [
            'submitLabel' => 'Mettre Ã jour le tÃ©lÃ©chargement',
            'downloadable' => $downloadable,
            'categories' => $categories
        ])
    </form>
</div>
@endsection