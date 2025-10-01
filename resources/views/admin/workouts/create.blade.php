@extends('layouts.admin')

@section('title', 'Créer un workout')
@section('page-title', 'Nouveau workout')
@section('page-description', 'Création d\'un nouveau workout')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.workouts.store') }}">
        @include('admin.workouts.partials.form', [
            'submitLabel' => 'Créer le workout',
            'categories' => $categories
        ])
    </form>
</div>
@endsection