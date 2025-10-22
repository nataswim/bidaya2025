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
            Survolez puis cliquez sur un muscle pour découvrir les exercices associés
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

    {{-- Conteneur des vues SVG --}}
    <div class="max-w-2xl mx-auto">
        <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg p-8">
            
            {{-- Vue de FACE --}}
            <div id="view-face" class="anatomy-view" style="display: block;">
                <div class="mx-auto" style="max-width: 500px;">
                    <object data="{{ asset('images/anatomy-front.svg') }}" type="image/svg+xml" class="w-full pointer-events-auto"></object>
                </div>
            </div>

            {{-- Vue de DOS --}}
            <div id="view-dos" class="anatomy-view" style="display: none;">
                <div class="mx-auto" style="max-width: 500px;">
                    <object data="{{ asset('images/anatomy-back.svg') }}" type="image/svg+xml" class="w-full pointer-events-auto"></object>
                </div>
            </div>
        </div>

        {{-- Légende --}}
        <div class="mt-6 text-center text-gray-600">
            <p class="text-sm">
                💡 <strong>Astuce :</strong> Survolez un muscle pour le mettre en surbrillance, puis cliquez pour accéder aux exercices
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

    /* Views */
    .anatomy-view {
        width: 100%;
    }

    /* Permettre les clics sur les SVG */
    object {
        pointer-events: all;
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
</script>
@endpush
@endsection