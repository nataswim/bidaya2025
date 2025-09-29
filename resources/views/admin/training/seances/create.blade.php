@extends('layouts.admin')

@section('title', 'Créer une séance')
@section('page-title', 'Nouvelle séance')
@section('page-description', 'Création d\'une nouvelle séance d\'entraînement')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.training.seances.store') }}">
        @include('admin.training.seances.partials.form', [
            'submitLabel' => 'Créer la séance',
            'series' => $series
        ])
    </form>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}
</style>
@endpush