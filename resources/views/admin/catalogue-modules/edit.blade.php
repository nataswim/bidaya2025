@extends('layouts.admin')

@section('title', 'Modifier un Module')
@section('page-title', 'Modifier le Module')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-modules.update', $catalogueModule) }}">
        @method('PUT')
        @include('admin.catalogue-modules.partials.form', [
            'submitLabel' => 'Mettre à jour le module',
            'module' => $catalogueModule
        ])
    </form>
</div>
@endsection