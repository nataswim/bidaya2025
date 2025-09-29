@extends('layouts.admin')

@section('title', 'Créer un plan')
@section('page-title', 'Nouveau plan d\'entraînement')
@section('page-description', 'Création d\'un nouveau plan')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.training.plans.store') }}">
        @include('admin.training.plans.partials.form', [
            'submitLabel' => 'Créer le plan',
            'cycles' => $cycles
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