@extends('layouts.admin')

@section('title', 'Catégories de médias')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Catégories de médias</h1>
                    <p class="text-muted mb-0">Organisez vos médias en catégories</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux médias
                    </a>
                    <button type="button" 
                            class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#categoryModal">
                        <i class="fas fa-plus me-2"></i>Nouvelle catégorie
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Catégorie</th>
                                        <th>Description</th>
                                        <th class="text-center">Médias</th>
                                        <th class="text-center">Ordre</th>
                                        <th class="text-center">Statut</th>
                                        <th class="text-center">Créée le</th>
                                        <th class="text-center pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded me-3" 
                                                         style="width: 24px; height: 24px; background-color: {{ $category->color }}"></div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $category->name }}</h6>
                                                        <small class="text-muted">{{ $category->slug }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ Str::limit($category->description, 60) ?: '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.media.index', ['category' => $category->id]) }}" 
                                                   class="text-decoration-none">
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $category->media_count }}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">{{ $category->order }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}-subtle text-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">
                                                    {{ $category->created_at->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('admin.media.index', ['category' => $category->id]) }}" 
                                                       class="btn btn-outline-primary btn-sm"
                                                       title="Voir les médias">
                                                        <i class="fas fa-images"></i>
                                                    </a>
                                                    @if($category->media_count === 0)
                                                        <form method="POST" 
                                                              action="{{ route('admin.media.categories.destroy', $category) }}"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    title="Supprimer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="button" 
                                                                class="btn btn-outline-secondary btn-sm"
                                                                title="Contient des médias"
                                                                disabled>
                                                            <i class="fas fa-lock"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-folder fa-4x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted">Aucune catégorie créée</h5>
                            <p class="text-muted mb-4">Créez votre première catégorie pour organiser vos médias.</p>
                            <button type="button" 
                                    class="btn btn-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#categoryModal">
                                <i class="fas fa-plus me-2"></i>Créer une catégorie
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Catégorie -->
@include('admin.media.modals.category')
@endsection

@push('scripts')
<script src="{{ asset('js/media-manager.js') }}"></script>
@endpush