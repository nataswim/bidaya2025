@extends('layouts.admin')

@section('title', 'Modifier un plan')
@section('page-title', 'Modifier le plan')
@section('page-description', 'Modification du plan : ' . $plan->titre)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.training.plans.update', $plan) }}">
        @method('PUT')
        @include('admin.training.plans.partials.form', [
            'submitLabel' => 'Mettre à jour le plan',
            'plan' => $plan,
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