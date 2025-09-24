@extends('layouts.admin')

@section('title', 'Modifier une catÃ©gorie')
@section('page-title', 'Modifier la catÃ©gorie')
@section('page-description', 'Modification de la catÃ©gorie : ' . $downloadCategory->name)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.download-categories.update', $downloadCategory) }}">
        @method('PUT')
        @include('admin.download-categories.partials.form', [
            'submitLabel' => 'Mettre Ã jour la catÃ©gorie',
            'category' => $downloadCategory
        ])
    </form>
</div>
@endsection