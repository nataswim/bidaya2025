@props([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'icon' => 'fas fa-chart-bar',
    'color' => 'primary',
    'change' => null,
    'changeType' => 'positive'
])

<div class="card border-0 shadow-sm h-100">
    <div class="card-body p-4">
        <div class="d-flex align-items-center">
            <div class="bg-{{ $color }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="{{ $icon }} text-{{ $color }}"></i>
            </div>
            <div class="flex-fill">
                @if($change)
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="fw-bold mb-0">{{ is_numeric($value) ? number_format($value) : $value }}</h3>
                        <span class="badge bg-{{ $changeType === 'positive' ? 'success' : 'danger' }}-subtle text-{{ $changeType === 'positive' ? 'success' : 'danger' }}">
                            <i class="fas fa-{{ $changeType === 'positive' ? 'arrow-up' : 'arrow-down' }} me-1"></i>{{ $change }}
                        </span>
                    </div>
                @else
                    <h3 class="fw-bold mb-0">{{ is_numeric($value) ? number_format($value) : $value }}</h3>
                @endif
                <p class="text-muted mb-0">{{ $subtitle }}</p>
                @if($title)
                    <small class="text-muted">{{ $title }}</small>
                @endif
            </div>
        </div>
    </div>
</div>