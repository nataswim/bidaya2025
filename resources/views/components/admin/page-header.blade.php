@props([
    'title' => '',
    'description' => '',
    'breadcrumbs' => [],
    'actions' => null
])

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 fw-bold mb-2">{{ $title }}</h1>
        @if($description)
            <p class="text-muted mb-0">{{ $description }}</p>
        @endif
        
        @if(!empty($breadcrumbs))
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none">{{ $breadcrumb['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>
    
    @if($actions)
        <div class="d-flex gap-2">
            {{ $actions }}
        </div>
    @endif
</div>