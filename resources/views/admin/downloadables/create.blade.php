@extends('layouts.admin')

@section('title', 'Creer un telechargement')
@section('page-title', 'Nouveau telechargement')
@section('page-description', 'Creation d\'un nouveau fichier telechargeable')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.downloadables.store') }}" enctype="multipart/form-data">
        @include('admin.downloadables.partials.form', [
            'submitLabel' => 'Creer le telechargement',
            'categories' => $categories
        ])
    </form>
</div>
@endsection