@extends('layouts.admin')

@section('title', 'Gestion des médias')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Gestion des médias</h1>
                    <p class="text-muted mb-0">Gérez vos images et fichiers multimédias</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" 
                            class="btn btn-outline-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#categoryModal">
                        <i class="fas fa-folder-plus me-2"></i>Nouvelle catégorie
                    </button>
                    <button type="button" 
                            class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#uploadModal">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Uploader des fichiers
                    </button>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                    <i class="fas fa-images text-primary fa-lg"></i>
                                </div>
                                <div>
                                    <div class="fw-bold fs-4">{{ number_format($stats['total_media']) }}</div>
                                    <small class="text-muted">Fichiers total</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                    <i class="fas fa-hdd text-info fa-lg"></i>
                                </div>
                                <div>
                                    <div class="fw-bold fs-4">{{ $stats['total_size_formatted'] }}</div>
                                    <small class="text-muted">Espace utilisé</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                    <i class="fas fa-folder text-success fa-lg"></i>
                                </div>
                                <div>
                                    <div class="fw-bold fs-4">{{ $stats['categories_count'] }}</div>
                                    <small class="text-muted">Catégories</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                    <i class="fas fa-clock text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <div class="fw-bold fs-4">{{ $stats['recent_uploads'] }}</div>
                                    <small class="text-muted">Cette semaine</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.media.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               class="form-control border-start-0" 
                               placeholder="Rechercher par nom...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12 par page</option>
                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 par page</option>
                        <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 par page</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-filter me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Reset
                        </a>
                        <a href="{{ route('admin.media.categories') }}" class="btn btn-outline-info">
                            <i class="fas fa-cog me-1"></i>Catégories
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Grille des médias -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($media->count() > 0)
                <div class="media-grid p-4">
                    <div class="row g-3">
                        @foreach($media as $item)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="media-item card border-0 shadow-sm h-100" 
                                     data-media-id="{{ $item->id }}"
                                     data-media-url="{{ $item->url }}"
                                     data-media-name="{{ $item->name }}">
                                    
                                    <!-- Image -->
                                    <div class="media-preview position-relative">
                                        <img src="{{ $item->url }}" 
                                             alt="{{ $item->alt_text ?: $item->name }}"
                                             class="card-img-top"
                                             style="height: 150px; object-fit: cover;"
                                             loading="lazy">
                                        
                                        <!-- Overlay avec actions -->
                                        <div class="media-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-light rounded-circle" 
                                                        onclick="viewMedia({{ $item->id }})"
                                                        title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-primary rounded-circle" 
                                                        onclick="selectMedia({{ $item->id }})"
                                                        title="Sélectionner">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger rounded-circle" 
                                                        onclick="deleteMedia({{ $item->id }})"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Badge catégorie -->
                                        @if($item->category)
                                            <span class="position-absolute top-0 start-0 m-2 badge" 
                                                  style="background-color: {{ $item->category->color }}">
                                                {{ $item->category->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Informations -->
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-1 text-truncate" title="{{ $item->name }}">
                                            {{ $item->name }}
                                        </h6>
                                        <div class="small text-muted">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span>{{ $item->dimensions ?: 'N/A' }}</span>
                                                <span>{{ $item->formatted_size }}</span>
                                            </div>
                                            <div class="text-truncate">
                                                {{ $item->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($media->hasPages())
                    <div class="border-top p-4">
                        {{ $media->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-images fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">Aucun média trouvé</h5>
                    <p class="text-muted mb-4">
                        @if($search || $categoryId)
                            Aucun résultat pour les critères sélectionnés.
                        @else
                            Commencez par uploader vos premiers fichiers.
                        @endif
                    </p>
                    <button type="button" 
                            class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#uploadModal">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Uploader des fichiers
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Upload -->
@include('admin.media.modals.upload')

<!-- Modal Catégorie -->
@include('admin.media.modals.category')

<!-- Modal Détails -->
@include('admin.media.modals.details')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/media-manager.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/media-manager.js') }}"></script>
@endpush