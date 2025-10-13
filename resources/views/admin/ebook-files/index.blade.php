@extends('layouts.admin')

@section('title', 'Gestion des Fichiers eBooks')
@section('page-title', 'Fichiers eBooks')
@section('page-description', 'Gestion des fichiers téléchargeables')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des fichiers -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-file-archive me-2"></i>Fichiers eBooks
                            </h5>
                            <small class="opacity-75">{{ $files->total() }} fichier(s) au total</small>
                        </div>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-upload me-2"></i>Uploader des fichiers
                        </button>
                    </div>
                </div>
                
                <!-- Filtres -->
                <div class="card-body border-bottom p-4 bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   class="form-control"
                                   placeholder="Rechercher un fichier...">
                        </div>
                        <div class="col-md-3">
                            <select name="format" class="form-select">
                                <option value="">Tous les formats</option>
                                <option value="pdf" {{ $format === 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="epub" {{ $format === 'epub' ? 'selected' : '' }}>EPUB</option>
                                <option value="mp4" {{ $format === 'mp4' ? 'selected' : '' }}>MP4</option>
                                <option value="zip" {{ $format === 'zip' ? 'selected' : '' }}>ZIP</option>
                                <option value="doc" {{ $format === 'doc' ? 'selected' : '' }}>DOC</option>
                                <option value="docx" {{ $format === 'docx' ? 'selected' : '' }}>DOCX</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Filtrer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste -->
                <div class="card-body p-0">
                    @if($files->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Fichier</th>
                                        <th class="border-0 px-4 py-3">Format</th>
                                        <th class="border-0 px-4 py-3">Taille</th>
                                        <th class="border-0 px-4 py-3">Utilisé par</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas {{ $file->icon }} fa-2x text-primary me-3"></i>
                                                    <div>
                                                        <h6 class="mb-0">{{ $file->name }}</h6>
                                                        <small class="text-muted">{{ $file->original_name }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-secondary">{{ strtoupper($file->format) }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $file->formatted_size }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($file->downloadables->count() > 0)
                                                    <span class="badge bg-success">{{ $file->downloadables->count() }} téléchargement(s)</span>
                                                @else
                                                    <span class="badge bg-warning">Non utilisé</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $file->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" 
                                                            data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" 
                                                               href="{{ route('admin.ebook-files.show', $file) }}">
                                                                <i class="fas fa-eye me-2"></i>Voir
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.ebook-files.destroy', $file) }}"
                                                                  onsubmit="return confirm('Supprimer ce fichier ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($files->hasPages())
                            <div class="card-footer bg-white">
                                {{ $files->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-archive fa-3x text-muted mb-3"></i>
                            <h5>Aucun fichier trouvé</h5>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="fas fa-upload me-2"></i>Uploader vos premiers fichiers
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar statistiques -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $stats['total_files'] }}</h4>
                                <small class="text-muted">Fichiers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $stats['total_size_formatted'] }}</h4>
                                <small class="text-muted">Espace</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-info mb-1">{{ $stats['recent_uploads'] }}</h4>
                                <small class="text-muted">Cette semaine</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <h6 class="fw-semibold mb-3">Par format</h6>
                    @foreach($stats['by_format'] as $format => $data)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-secondary">{{ strtoupper($format) }}</span>
                            <span class="small text-muted">{{ $data['count'] }} fichiers</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.downloadables.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Gérer les téléchargements
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload -->
@include('admin.ebook-files.modals.upload')

@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}
</style>
@endpush