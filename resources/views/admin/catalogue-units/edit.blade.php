@extends('layouts.admin')

@section('title', 'Modifier une Unité')
@section('page-title', 'Modifier l\'Unité')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-units.update', $catalogueUnit) }}">
        @method('PUT')
        @include('admin.catalogue-units.partials.form', [
            'submitLabel' => 'Mettre à jour l\'unité',
            'unit' => $catalogueUnit
        ])
    </form>
</div>
@endsection