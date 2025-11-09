@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center flex-wrap mb-0">
            {{-- Boutons Précédent et Suivant sur la première ligne --}}
            <li class="page-item w-100 d-flex justify-content-center mb-3">
                <div class="d-flex gap-2">
                    {{-- Bouton Précédent --}}
                    @if ($paginator->onFirstPage())
                        <span class="btn btn-secondary disabled px-4">
                            <i class="fas fa-chevron-left me-2"></i>Précédent
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-primary px-4" rel="prev">
                            <i class="fas fa-chevron-left me-2"></i>Précédent
                        </a>
                    @endif

                    {{-- Bouton Suivant --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-primary px-4" rel="next">
                            Suivant<i class="fas fa-chevron-right ms-2"></i>
                        </a>
                    @else
                        <span class="btn btn-secondary disabled px-4">
                            Suivant<i class="fas fa-chevron-right ms-2"></i>
                        </span>
                    @endif
                </div>
            </li>

            {{-- Affichage de TOUTES les pages avec 5 par ligne --}}
            @php
                $totalPages = $paginator->lastPage();
                $currentPage = $paginator->currentPage();
            @endphp

            @for ($page = 1; $page <= $totalPages; $page++)
                {{-- Retour à la ligne après chaque 5 liens --}}
                @if (($page - 1) % 5 === 0 && $page !== 1)
                    <li class="w-100 d-none d-md-block" style="height: 0.5rem;"></li>
                @endif

                <li class="page-item {{ $page === $currentPage ? 'active' : '' }} mx-1 mb-2">
                    @if ($page === $currentPage)
                        <span class="page-link bg-primary border-primary fw-bold" style="min-width: 45px; text-align: center;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="page-link" style="min-width: 45px; text-align: center;">
                            {{ $page }}
                        </a>
                    @endif
                </li>
            @endfor
        </ul>
    </nav>
@endif