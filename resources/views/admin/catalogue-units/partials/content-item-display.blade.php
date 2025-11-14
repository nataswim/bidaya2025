<div class="content-item-display border rounded p-3 mb-3" data-index="{{ $index }}">
    {{-- Champs cachés pour la soumission --}}
    @if(!$isNew && isset($content->id))
        <input type="hidden" name="contents[{{ $index }}][id]" value="{{ $content->id }}">
    @endif
    
    <input type="hidden" name="contents[{{ $index }}][contentable_type]" value="{{ $content->contentable_type ?? '' }}">
    <input type="hidden" name="contents[{{ $index }}][contentable_id]" value="{{ $content->contentable_id ?? '' }}">
    <input type="hidden" name="contents[{{ $index }}][order]" value="{{ $content->order ?? ($index + 1) }}" class="order-input">
    <input type="hidden" name="contents[{{ $index }}][is_required]" value="{{ ($content->is_required ?? true) ? '1' : '0' }}">
    <input type="hidden" name="contents[{{ $index }}][custom_title]" value="{{ $content->custom_title ?? '' }}">
    <input type="hidden" name="contents[{{ $index }}][custom_description]" value="{{ $content->custom_description ?? '' }}">
    <input type="hidden" name="contents[{{ $index }}][duration_minutes]" value="{{ $content->duration_minutes ?? '' }}">
    
    <div class="d-flex justify-content-between align-items-start">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-secondary order-badge">{{ $content->order ?? ($index + 1) }}</span>
                <span class="badge bg-info-subtle text-info">
                    @php
                        $typeLabels = [
                            'App\\Models\\Post' => 'Article',
                            'App\\Models\\Video' => 'Vidéo',
                            'App\\Models\\Downloadable' => 'Fichier téléchargeable',
                            'App\\Models\\Fiche' => 'Fiche',
                            'App\\Models\\Exercice' => 'Exercice',
                            'App\\Models\\Workout' => 'Entraînement',
                            'App\\Models\\EbookFile' => 'E-book',
                        ];
                        $contentType = $content->contentable_type ?? '';
                        echo $typeLabels[$contentType] ?? 'Contenu';
                    @endphp
                </span>
                @if($content->is_required ?? true)
                    <span class="badge bg-success-subtle text-success">Obligatoire</span>
                @else
                    <span class="badge bg-warning-subtle text-warning">Optionnel</span>
                @endif
            </div>
            
            <h6 class="mb-1">
                @if($isNew)
                    {{ $content->title ?? 'Nouveau contenu' }}
                @else
                    @if(!empty($content->custom_title))
                        {{ $content->custom_title }}
                        <small class="text-muted">(Titre personnalisé)</small>
                    @elseif(isset($content->contentable))
                        {{ $content->contentable->title ?? $content->contentable->name ?? 'Sans titre' }}
                    @else
                        Contenu ID: {{ $content->contentable_id ?? 'N/A' }}
                    @endif
                @endif
            </h6>
            
            @if(!empty($content->custom_description))
                <small class="text-muted d-block mt-1">{{ Str::limit($content->custom_description, 100) }}</small>
            @endif
            
            @if(!empty($content->duration_minutes))
                <small class="text-muted d-block mt-1">
                    <i class="fas fa-clock me-1"></i>{{ $content->duration_minutes }} minutes
                </small>
            @endif
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeContent(this)" title="Supprimer">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>