<div class="card">
    <div class="card-body">
        @if($urls->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune URL trouvée. Lancez la découverte pour commencer.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discoverModal">
                    <i class="bi bi-search"></i> Découvrir les URLs
                </button>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>URL</th>
                            <th width="100">Type</th>
                            <th width="120">Source</th>
                            <th width="80">Priorité</th>
                            <th width="120">Fréquence</th>
                            <th width="100">Statut</th>
                            <th width="150">Dernière Modif.</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urls as $url)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input url-checkbox" value="{{ $url->id }}">
                                </td>
                                <td>
                                    <a href="{{ $url->url }}" target="_blank" class="text-decoration-none">
                                        {{ Str::limit($url->url, 60) }}
                                        <i class="bi bi-box-arrow-up-right text-muted small"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $url->type_badge }}">
                                        {{ ucfirst($url->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($url->source)
                                        <span class="badge bg-secondary">{{ $url->source_label }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $url->priority }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $url->changefreq_badge }}">
                                        {{ $url->changefreq }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if($url->is_approved)
                                            <span class="badge bg-success">✓ Approuvée</span>
                                        @else
                                            <span class="badge bg-warning">⏳ En attente</span>
                                        @endif
                                        @if($url->is_active)
                                            <span class="badge bg-success">🟢</span>
                                        @else
                                            <span class="badge bg-secondary">🔴</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $url->last_modified ? $url->last_modified->format('d/m/Y H:i') : $url->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <form method="POST" action="{{ route('admin.sitemap.toggle', $url) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                class="btn {{ $url->is_approved ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                title="{{ $url->is_approved ? 'Désapprouver' : 'Approuver' }}">
                                                @if($url->is_approved)
                                                    <i class="bi bi-x-circle"></i>
                                                @else
                                                    <i class="bi bi-check-circle"></i>
                                                @endif
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.sitemap.destroy', $url) }}" 
                                            class="d-inline" 
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette URL ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Actions supplémentaires --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Affichage de {{ $urls->firstItem() ?? 0 }} à {{ $urls->lastItem() ?? 0 }} sur {{ $urls->total() }} résultats
                    </small>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cleanModal">
                        <i class="bi bi-trash"></i> Tout nettoyer
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>