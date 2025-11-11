@extends('layouts.admin')

@section('title', 'Créer une Unité')
@section('page-title', 'Nouvelle Unité Pédagogique')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-units.store') }}">
        @include('admin.catalogue-units.partials.form', [
            'submitLabel' => 'Créer l\'unité'
        ])
    </form>
</div>
@endsection