@extends('layouts.admin')

@section('title', 'Créer un Module')
@section('page-title', 'Nouveau Module')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.catalogue-modules.store') }}">
        @include('admin.catalogue-modules.partials.form', [
            'submitLabel' => 'Créer le module'
        ])
    </form>
</div>
@endsection