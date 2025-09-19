<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Accueil') - {{ config('app.name') }}</title>
    
    <!-- Préchargement des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- SEO Meta -->
    <meta name="description" content="@yield('meta_description', 'Votre plateforme de référence pour le développement web et les technologies modernes')">
    <meta name="keywords" content="@yield('meta_keywords', 'développement web, Laravel, PHP, technologies')">
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-light">
    @include('layouts.partials.public-header')
    
    <!-- Messages Flash -->
    @if(session('success') || session('error') || session('warning'))
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    @endif
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.partials.public-footer')
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>