@extends('layouts.admin')

@section('title', 'Modifier un workout')
@section('page-title', 'Modifier le workout')
@section('page-description', 'Modification du workout : ' . $workout->title)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.workouts.update', $workout) }}">
        @method('PUT')
        @include('admin.workouts.partials.form', [
            'submitLabel' => 'Mettre à jour le workout',
            'workout' => $workout,
            'categories' => $categories
        ])
    </form>
</div>
@endsection