<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Title --}}
    <title>@yield('title', 'Accueil') - {{ config('app.name') }}</title>
    
    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', 'Plateforme complète d\'entraînement sportif avec programmes, exercices, outils de calcul et ressources pour tous niveaux')">
    <meta name="keywords" content="@yield('meta_keywords', 'entraînement sportif, natation, musculation, plans d\'entraînement, exercices, outils calcul, performance sportive')">
    
    
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    {{-- Preconnect fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Styles --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
        {{-- CSS Social Share --}}
    <link rel="stylesheet" href="{{ asset('css/social-share.css') }}">

    @stack('styles')
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RDDF8VW92G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-RDDF8VW92G');
</script>

<meta name="msvalidate.01" content="8D79868FFCAC25E19818E1971977FC3F" />


</head>
<body class="bg-light">
    
    {{-- Messages Flash --}}
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
        
    
    @stack('scripts')
</body>
</html>