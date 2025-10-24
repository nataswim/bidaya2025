@extends('layouts.public')

@section('title', 'Carte Anatomique - Exercices par Muscle')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- En-tête --}}
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Carte Anatomique Interactive
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-6">
            Cliquez sur un muscle pour découvrir les exercices associés
        </p>

        {{-- Toggle Face/Dos --}}
        <div class="flex justify-center mb-6">
            <div class="inline-flex rounded-lg border border-gray-300 bg-white p-1 shadow-sm">
                <button 
                    id="btn-face" 
                    class="view-toggle px-8 py-3 rounded-md font-medium transition-colors active text-base"
                    onclick="switchView('face')"
                >
                    Vue de Face
                </button>
                <button 
                    id="btn-dos" 
                    class="view-toggle px-8 py-3 rounded-md font-medium transition-colors text-base"
                    onclick="switchView('dos')"
                >
                    Vue de Dos
                </button>
            </div>
        </div>
    </div>

    {{-- Conteneur principal --}}
    <div class="max-w-3xl mx-auto">
        <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg p-8">
            
            {{-- VUE DE FACE --}}
            <div id="view-face" class="anatomy-container" style="display: block;">
                <div class="relative mx-auto" style="max-width: 600px;">
                    {{-- SVG de base --}}
                    <img src="{{ asset('images/anatomy-front.svg') }}" alt="Vue de face" class="w-full h-auto">
                    
                    {{-- Zones cliquables --}}
                    {{-- COU --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'complementaires', 'sousCategory' => 'cou']) }}" 
                       class="muscle-zone" 
                       style="top: 4%; left: 43%; width: 14%; height: 5%;"
                       data-muscle="Cou">
                    </a>
                    
                    {{-- ÉPAULES GAUCHE --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                       class="muscle-zone" 
                       style="top: 9%; left: 28%; width: 15%; height: 8%;"
                       data-muscle="Épaules">
                    </a>
                    
                    {{-- ÉPAULES DROITE --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                       class="muscle-zone" 
                       style="top: 9%; left: 57%; width: 15%; height: 8%;"
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

            {{-- VUE DE DOS --}}
            <div id="view-dos" class="anatomy-container" style="display: none;">
                <div class="relative mx-auto" style="max-width: 600px;">
                    {{-- SVG de base --}}
                    <img src="{{ asset('images/anatomy-back.svg') }}" alt="Vue de dos" class="w-full h-auto">
                    
                    {{-- Zones cliquables --}}
                    {{-- TRAPÈZES --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'complementaires', 'sousCategory' => 'trapezes']) }}" 
                       class="muscle-zone" 
                       style="top: 8%; left: 35%; width: 30%; height: 10%;"
                       data-muscle="Trapèzes">
                    </a>
                    
                    {{-- ÉPAULES GAUCHE (DOS) --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                       class="muscle-zone" 
                       style="top: 10%; left: 25%; width: 13%; height: 8%;"
                       data-muscle="Épaules">
                    </a>
                    
                    {{-- ÉPAULES DROITE (DOS) --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'haut-du-corps', 'sousCategory' => 'epaules']) }}" 
                       class="muscle-zone" 
                       style="top: 10%; left: 62%; width: 13%; height: 8%;"
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
                       style="top: 44%; left: 38%; width: 24%; height: 10%;"
                       data-muscle="Bas du dos">
                    </a>
                    
                    {{-- FESSIERS --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'fessiers']) }}" 
                       class="muscle-zone" 
                       style="top: 54%; left: 36%; width: 28%; height: 10%;"
                       data-muscle="Fessiers">
                    </a>
                    
                    {{-- ISCHIO-JAMBIERS GAUCHE --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'ischio-jambiers']) }}" 
                       class="muscle-zone" 
                       style="top: 64%; left: 34%; width: 12%; height: 16%;"
                       data-muscle="Ischio-jambiers">
                    </a>
                    
                    {{-- ISCHIO-JAMBIERS DROIT --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'ischio-jambiers']) }}" 
                       class="muscle-zone" 
                       style="top: 64%; left: 54%; width: 12%; height: 16%;"
                       data-muscle="Ischio-jambiers">
                    </a>
                    
                    {{-- MOLLETS GAUCHE (DOS) --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                       class="muscle-zone" 
                       style="top: 81%; left: 35%; width: 10%; height: 14%;"
                       data-muscle="Mollets">
                    </a>
                    
                    {{-- MOLLETS DROIT (DOS) --}}
                    <a href="{{ route('exercices.sous-category', ['category' => 'bas-du-corps', 'sousCategory' => 'mollets']) }}" 
                       class="muscle-zone" 
                       style="top: 81%; left: 55%; width: 10%; height: 14%;"
                       data-muscle="Mollets">
                    </a>
                </div>
            </div>
            
            {{-- Tooltip --}}
            <div id="muscle-tooltip" class="muscle-tooltip"></div>
        </div>

        {{-- Légende --}}
        <div class="mt-6 text-center text-gray-600">
            <p class="text-sm">
                💡 <strong>Astuce :</strong> Survolez un muscle pour voir son nom, cliquez pour accéder aux exercices
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Toggle buttons */
    .view-toggle {
        color: #6b7280;
        background-color: transparent;
    }
    
    .view-toggle.active {
        background-color: #3b82f6;
        color: white;
    }
    
    .view-toggle:hover:not(.active) {
        background-color: #f3f4f6;
    }

    /* Conteneur anatomique */
    .anatomy-container {
        width: 100%;
        position: relative;
    }

    /* Zones musculaires cliquables */
    .muscle-zone {
        position: absolute;
        background-color: rgba(59, 130, 246, 0.15);
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .muscle-zone:hover {
        background-color: rgba(59, 130, 246, 0.35);
        border-color: #3b82f6;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    /* Tooltip */
    .muscle-tooltip {
        position: fixed;
        background: rgba(30, 64, 175, 0.95);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        white-space: nowrap;
    }

    .muscle-tooltip.show {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .muscle-zone {
            border-width: 1px;
        }
        
        .muscle-tooltip {
            font-size: 12px;
            padding: 6px 12px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction pour changer de vue
    function switchView(view) {
        document.getElementById('view-face').style.display = 'none';
        document.getElementById('view-dos').style.display = 'none';
        document.getElementById('view-' + view).style.display = 'block';
        
        document.getElementById('btn-face').classList.remove('active');
        document.getElementById('btn-dos').classList.remove('active');
        document.getElementById('btn-' + view).classList.add('active');
    }

    // Gestion du tooltip
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.getElementById('muscle-tooltip');
        const muscleZones = document.querySelectorAll('.muscle-zone');

        muscleZones.forEach(zone => {
            const muscleName = zone.getAttribute('data-muscle');

            zone.addEventListener('mouseenter', function(e) {
                tooltip.textContent = muscleName;
                tooltip.classList.add('show');
            });

            zone.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
            });

            zone.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY - 40) + 'px';
            });
        });
    });
</script>
@endpush
@endsection