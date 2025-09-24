@extends('layouts.admin')

@section('title', 'CrÃ©er une catÃ©gorie de tÃ©lÃ©chargement')
@section('page-title', 'Nouvelle catÃ©gorie')
@section('page-description', 'CrÃ©ation d\'une nouvelle catÃ©gorie de tÃ©lÃ©chargement')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.download-categories.store') }}">
        @include('admin.download-categories.partials.form', [
            'submitLabel' => 'CrÃ©er la catÃ©gorie'
        ])
    </form>
</div>
@endsection