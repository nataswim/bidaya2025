@extends('layouts.admin')

@section('title', 'Modifier une Section')
@section('page-title', 'Modifier la Section')
@section('page-description', 'Modification de : ' . $catalogueSection->name)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-sections.update', $catalogueSection) }}">
        @method('PUT')
        @include('admin.catalogue-sections.partials.form', [
            'submitLabel' => 'Mettre à jour la section',
            'section' => $catalogueSection
        ])
    </form>
</div>
@endsection