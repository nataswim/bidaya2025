<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Administration</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Quill.js CSS - UNE SEULE FOIS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('css/quill-advanced.css') }}" rel="stylesheet">
<link href="{{ asset('css/media-selector.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        @include('layouts.partials.admin-nav')
        
        <div class="flex-fill d-flex flex-column">
            @include('layouts.partials.admin-header')
            
            <main class="flex-fill p-4">
                @if(session('success') || session('error'))
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Quill.js - UNE SEULE FOIS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{ asset('js/quill-advanced.js') }}"></script>
<!-- Sélecteur de médias -->
<script src="{{ asset('js/media-selector.js') }}"></script>


    @stack('scripts')
</body>
</html>