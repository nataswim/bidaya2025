@props(['align' => 'right', 'width' => '48'])

@php
$alignmentClasses = match($align) {
    'left' => 'origin-top-left left-0',
    'top' => 'origin-top',
    default => 'origin-top-right right-0'
};

$widthClass = match($width) {
    '48' => 'w-48',
    default => ''
};
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition class="absolute z-50 mt-2 {{ $widthClass }} rounded-md shadow-lg {{ $alignmentClasses }}">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
            {{ $content }}
        </div>
    </div>
</div>
