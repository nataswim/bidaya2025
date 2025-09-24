@extends('layouts.admin')

@section('title', 'CrÃ©er un tÃ©lÃ©chargement')
@section('page-title', 'Nouveau tÃ©lÃ©chargement')
@section('page-description', 'CrÃ©ation d\'un nouveau fichier tÃ©lÃ©chargeable')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.downloadables.store') }}" enctype="multipart/form-data">
        @include('admin.downloadables.partials.form', [
            'submitLabel' => 'CrÃ©er le tÃ©lÃ©chargement',
            'categories' => $categories
        ])
    </form>
</div>
@endsection