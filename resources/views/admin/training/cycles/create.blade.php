@extends('layouts.admin')

@section('title', 'Créer un cycle')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white p-4">
            <h5 class="mb-0">
                <i class="fas fa-sync-alt me-2"></i>Nouveau Cycle
            </h5>
        </div>
        <form method="POST" action="{{ route('admin.training.cycles.store') }}">
            @include('admin.training.cycles.partials.form', [
                'submitLabel' => 'Créer le cycle',
                'seances' => $seances
            ])
        </form>
    </div>
</div>
@endsection