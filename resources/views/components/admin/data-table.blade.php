@props([
    'headers' => [],
    'data' => [],
    'searchRoute' => null,
    'createRoute' => null,
    'createLabel' => 'Nouveau',
    'emptyMessage' => 'Aucune donnÃ©e disponible',
    'emptyIcon' => 'fas fa-inbox'
])

<div class="card border-0 shadow-sm">
    <!-- En-tête -->
    <div class="card-header bg-white border-bottom p-4">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{ $title ?? 'Liste' }}</h5>
            @if($createRoute)
                <a href="{{ $createRoute }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ $createLabel }}
                </a>
            @endif
        </div>
    </div>
    
    <!-- Filtres de recherche -->
    @if($searchRoute)
        <div class="card-body border-bottom p-4">
            <form method="GET" action="{{ $searchRoute }}" class="row g-3">
                {{ $searchForm ?? '' }}
            </form>
        </div>
    @endif
    
    <!-- Tableau -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            @if(!empty($headers))
                <thead class="table-light">
                    <tr>
                        @foreach($headers as $header)
                            <th class="border-0 py-3 {{ $header['class'] ?? '' }}">
                                {{ $header['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($pagination) && $pagination->hasPages())
        <div class="card-footer bg-white border-top p-4">
            {{ $pagination->links() }}
        </div>
    @endif
</div>