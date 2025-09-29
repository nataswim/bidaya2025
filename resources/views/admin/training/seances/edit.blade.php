@extends('layouts.admin')

@section('title', 'Modifier une séance')
@section('page-title', 'Modifier la séance')
@section('page-description', 'Modification de la séance : ' . $seance->titre)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.training.seances.update', $seance) }}">
        @method('PUT')
        @include('admin.training.seances.partials.form', [
            'submitLabel' => 'Mettre à jour la séance',
            'seance' => $seance,
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