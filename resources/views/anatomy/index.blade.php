@extends('layouts.public')

@section('title', 'Carte Anatomique - Exercices par Muscle')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4">
        
        {{-- En-tête --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Carte Anatomique Interactive
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto mb-6">
                Cliquez sur un muscle pour découvrir les exercices associés
            </p>

            {{-- Toggle Face/Dos --}}
            <div class="flex justify-center mb-6">
                <div class="inline-flex rounded-lg border-2 border-blue-500 bg-white p-1 shadow-md">
                    <button 
                        id="btn-face" 
                        class="view-toggle px-6 md:px-8 py-2 md:py-3 rounded-md font-semibold transition-all active text-sm md:text-base"
                        onclick="switchView('face')"
                    >
                        Vue de Face
                    </button>
                    <button 
                        id="btn-dos" 
                        class="view-toggle px-6 md:px-8 py-2 md:py-3 rounded-md font-semibold transition-all text-sm md:text-base"
                        onclick="switchView('dos')"
                    >
                        Vue de Dos
                    </button>
                </div>
            </div>
        </div>

        {{-- Conteneur principal --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                
                {{-- VUE DE FACE --}}
                <div id="view-face" class="anatomy-view">
                    <div class="anatomy-wrapper">
                        {{-- SVG de base --}}
                        <img 
                            src="{{ asset('images/anatomy-front.svg') }}" 
                            alt="Vue de face" 
                            class="anatomy-image"
                            id="img-face"
                        >
                        
                        {{-- Container pour les zones cliquables --}}
                        <div class="zones-container" id="zones-face">
                            {{-- COU --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'complementaires', 'sousCategory' => 'cou']) }}" 
                               class="muscle-zone" 
                               style="top: 12%; left: 43%; width: 14%; height: 5%;"
                               data-muscle="Cou">
                            </a>
                            
                            {{-- ÉPAULES GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                               class="muscle-zone" 
                               style="top: 17%; left: 28%; width: 15%; height: 8%;"
                               data-muscle="Épaules">
                            </a>
                            
                            {{-- ÉPAULES DROITE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                               class="muscle-zone" 
                               style="top: 17%; left: 57%; width: 15%; height: 8%;"
                               data-muscle="Épaules">
                            </a>
                            
                            {{-- PECTORAUX --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'pectoraux-poitrine']) }}" 
                               class="muscle-zone" 
                               style="top: 17%; left: 37%; width: 26%; height: 12%;"
                               data-muscle="Pectoraux">
                            </a>
                            
                            {{-- BICEPS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'biceps']) }}" 
                               class="muscle-zone" 
                               style="top: 18%; left: 20%; width: 10%; height: 14%;"
                               data-muscle="Biceps">
                            </a>
                            
                            {{-- BICEPS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'biceps']) }}" 
                               class="muscle-zone" 
                               style="top: 18%; left: 70%; width: 10%; height: 14%;"
                               data-muscle="Biceps">
                            </a>
                            
                            {{-- AVANT-BRAS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'avant-bras']) }}" 
                               class="muscle-zone" 
                               style="top: 32%; left: 16%; width: 9%; height: 14%;"
                               data-muscle="Avant-bras">
                            </a>
                            
                            {{-- AVANT-BRAS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'avant-bras']) }}" 
                               class="muscle-zone" 
                               style="top: 32%; left: 75%; width: 9%; height: 14%;"
                               data-muscle="Avant-bras">
                            </a>
                            
                            {{-- ABDOMINAUX --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'centre-du-corps', 'sousCategory' => 'abdominaux']) }}" 
                               class="muscle-zone" 
                               style="top: 29%; left: 39%; width: 22%; height: 18%;"
                               data-muscle="Abdominaux">
                            </a>
                            
                            {{-- OBLIQUES GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'centre-du-corps', 'sousCategory' => 'obliques']) }}" 
                               class="muscle-zone" 
                               style="top: 30%; left: 32%; width: 7%; height: 15%;"
                               data-muscle="Obliques">
                            </a>
                            
                            {{-- OBLIQUES DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'centre-du-corps', 'sousCategory' => 'obliques']) }}" 
                               class="muscle-zone" 
                               style="top: 30%; left: 61%; width: 7%; height: 15%;"
                               data-muscle="Obliques">
                            </a>
                            
                            {{-- QUADRICEPS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'quadriceps']) }}" 
                               class="muscle-zone" 
                               style="top: 51%; left: 33%; width: 12%; height: 22%;"
                               data-muscle="Quadriceps">
                            </a>
                            
                            {{-- QUADRICEPS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'quadriceps']) }}" 
                               class="muscle-zone" 
                               style="top: 51%; left: 55%; width: 12%; height: 22%;"
                               data-muscle="Quadriceps">
                            </a>
                            
                            {{-- ADDUCTEURS --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'adducteurs']) }}" 
                               class="muscle-zone" 
                               style="top: 52%; left: 45%; width: 10%; height: 20%;"
                               data-muscle="Adducteurs">
                            </a>
                            
                            {{-- MOLLETS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                               class="muscle-zone" 
                               style="top: 75%; left: 35%; width: 10%; height: 17%;"
                               data-muscle="Mollets">
                            </a>
                            
                            {{-- MOLLETS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                               class="muscle-zone" 
                               style="top: 75%; left: 55%; width: 10%; height: 17%;"
                               data-muscle="Mollets">
                            </a>
                        </div>
                    </div>
                </div>

                {{-- VUE DE DOS --}}
                <div id="view-dos" class="anatomy-view" style="display: none;">
                    <div class="anatomy-wrapper">
                        {{-- SVG de base --}}
                        <img 
                            src="{{ asset('images/anatomy-back.svg') }}" 
                            alt="Vue de dos" 
                            class="anatomy-image"
                            id="img-dos"
                        >
                        
                        {{-- Container pour les zones cliquables --}}
                        <div class="zones-container" id="zones-dos">
                            {{-- TRAPÈZES --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'complementaires', 'sousCategory' => 'trapezes']) }}" 
                               class="muscle-zone" 
                               style="top: 16%; left: 35%; width: 30%; height: 10%;"
                               data-muscle="Trapèzes">
                            </a>
                            
                            {{-- ÉPAULES GAUCHE (DOS) --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                               class="muscle-zone" 
                               style="top: 18%; left: 25%; width: 13%; height: 8%;"
                               data-muscle="Épaules">
                            </a>
                            
                            {{-- ÉPAULES DROITE (DOS) --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                               class="muscle-zone" 
                               style="top: 18%; left: 62%; width: 13%; height: 8%;"
                               data-muscle="Épaules">
                            </a>
                            
                            {{-- HAUT DU DOS --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'haut-du-dos']) }}" 
                               class="muscle-zone" 
                               style="top: 18%; left: 36%; width: 28%; height: 10%;"
                               data-muscle="Haut du dos">
                            </a>
                            
                            {{-- TRICEPS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'triceps']) }}" 
                               class="muscle-zone" 
                               style="top: 20%; left: 18%; width: 10%; height: 14%;"
                               data-muscle="Triceps">
                            </a>
                            
                            {{-- TRICEPS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'triceps']) }}" 
                               class="muscle-zone" 
                               style="top: 20%; left: 72%; width: 10%; height: 14%;"
                               data-muscle="Triceps">
                            </a>
                            
                            {{-- GRANDS DORSAUX --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'grands-dorsaux']) }}" 
                               class="muscle-zone" 
                               style="top: 28%; left: 30%; width: 40%; height: 16%;"
                               data-muscle="Grands Dorsaux">
                            </a>
                            
                            {{-- BAS DU DOS (LOMBAIRES) --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'centre-du-corps', 'sousCategory' => 'bas-du-dos']) }}" 
                               class="muscle-zone" 
                               style="top: 36%; left: 38%; width: 24%; height: 10%;"
                               data-muscle="Bas du dos">
                            </a>
                            
                            {{-- FESSIERS --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'fessiers']) }}" 
                               class="muscle-zone" 
                               style="top: 46%; left: 36%; width: 28%; height: 10%;"
                               data-muscle="Fessiers">
                            </a>
                            
                            {{-- ISCHIO-JAMBIERS GAUCHE --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'ischio-jambiers']) }}" 
                               class="muscle-zone" 
                               style="top: 56%; left: 34%; width: 12%; height: 16%;"
                               data-muscle="Ischio-jambiers">
                            </a>
                            
                            {{-- ISCHIO-JAMBIERS DROIT --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'ischio-jambiers']) }}" 
                               class="muscle-zone" 
                               style="top: 56%; left: 54%; width: 12%; height: 16%;"
                               data-muscle="Ischio-jambiers">
                            </a>
                            
                            {{-- MOLLETS GAUCHE (DOS) --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                               class="muscle-zone" 
                               style="top: 74%; left: 35%; width: 10%; height: 14%;"
                               data-muscle="Mollets">
                            </a>
                            
                            {{-- MOLLETS DROIT (DOS) --}}
                            <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                               class="muscle-zone" 
                               style="top: 74%; left: 55%; width: 10%; height: 14%;"
                               data-muscle="Mollets">
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Tooltip --}}
                <div id="muscle-tooltip" class="muscle-tooltip"></div>
            </div>

            {{-- Légende --}}
            <div class="mt-6 text-center text-gray-600 px-4">
                <p class="text-xs md:text-sm">
                    💡 <strong>Astuce :</strong> Survolez un muscle pour voir son nom, cliquez pour accéder aux exercices
                </p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Toggle buttons */
    .view-toggle {
        color: #6b7280;
        background-color: transparent;
        transition: all 0.3s ease;
    }
    
    .view-toggle.active {
        background-color: #3b82f6;
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
    }
    
    .view-toggle:hover:not(.active) {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    /* Conteneur anatomique - FIX PRINCIPAL */
    .anatomy-view {
        width: 100%;
        display: block;
    }

    .anatomy-wrapper {
        position: relative;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 1rem;
    }

    .anatomy-image {
        display: block;
        width: 100%;
        height: auto;
        max-width: 100%;
    }

    /* Container des zones - ALIGNEMENT PARFAIT */
    .zones-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    /* Zones musculaires cliquables */
    .muscle-zone {
        position: absolute;
        background-color: rgb(4 173 185 / 40%);
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        pointer-events: auto;
        display: block;
    }
    
    .muscle-zone:hover {
        background-color: rgb(4 55 185 / 41%);
        border-color: #3b82f6;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
        z-index: 10;
    }

    /* Tooltip */
    .muscle-tooltip {
        position: fixed;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        white-space: nowrap;
    }

    .muscle-tooltip.show {
        opacity: 1;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .anatomy-wrapper {
            padding: 0.5rem;
        }

        .muscle-zone {
            border-width: 1.5px;
            border-radius: 6px;
        }
        
        .muscle-zone:hover {
            transform: scale(1.03);
        }
        
        .muscle-tooltip {
            font-size: 12px;
            padding: 6px 12px;
        }
    }

    @media (max-width: 480px) {
        .anatomy-wrapper {
            padding: 0.25rem;
        }

        .muscle-zone {
            border-width: 1px;
            border-radius: 4px;
        }
        
        .muscle-tooltip {
            font-size: 11px;
            padding: 5px 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction pour changer de vue
    function switchView(view) {
        const faceView = document.getElementById('view-face');
        const dosView = document.getElementById('view-dos');
        const btnFace = document.getElementById('btn-face');
        const btnDos = document.getElementById('btn-dos');

        if (view === 'face') {
            faceView.style.display = 'block';
            dosView.style.display = 'none';
            btnFace.classList.add('active');
            btnDos.classList.remove('active');
        } else {
            faceView.style.display = 'none';
            dosView.style.display = 'block';
            btnFace.classList.remove('active');
            btnDos.classList.add('active');
        }
    }

    // Gestion du tooltip et des interactions
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.getElementById('muscle-tooltip');
        const muscleZones = document.querySelectorAll('.muscle-zone');

        muscleZones.forEach(zone => {
            const muscleName = zone.getAttribute('data-muscle');

            // Desktop: hover
            zone.addEventListener('mouseenter', function(e) {
                tooltip.textContent = muscleName;
                tooltip.classList.add('show');
                updateTooltipPosition(e);
            });

            zone.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
            });

            zone.addEventListener('mousemove', updateTooltipPosition);

            // Mobile: touch
            zone.addEventListener('touchstart', function(e) {
                e.preventDefault();
                tooltip.textContent = muscleName;
                tooltip.classList.add('show');
                
                const touch = e.touches[0];
                tooltip.style.left = (touch.clientX + 15) + 'px';
                tooltip.style.top = (touch.clientY - 50) + 'px';

                // Navigation après un court délai
                setTimeout(() => {
                    window.location.href = zone.getAttribute('href');
                }, 300);
            }, { passive: false });

            zone.addEventListener('touchend', function() {
                setTimeout(() => {
                    tooltip.classList.remove('show');
                }, 500);
            });
        });

        function updateTooltipPosition(e) {
            const offsetX = 15;
            const offsetY = 40;
            
            let x = e.clientX + offsetX;
            let y = e.clientY - offsetY;
            
            // Empêcher le tooltip de sortir de l'écran
            const tooltipRect = tooltip.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            if (x + tooltipRect.width > viewportWidth) {
                x = e.clientX - tooltipRect.width - offsetX;
            }
            
            if (y < 0) {
                y = e.clientY + offsetY;
            }
            
            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        }
    });
</script>
@endpush
@endsection