<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Administration</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Navigation horizontale CSS -->
    <link href="{{ asset('css/admin-nav-horizontal.css') }}" rel="stylesheet">
    
    <!-- Footer admin CSS -->
    <link href="{{ asset('css/admin-footer.css') }}" rel="stylesheet">
    
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('css/quill-advanced.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media-selector.css') }}" rel="stylesheet">

    <style>
        /* Structure de la page pour footer sticky */
        html, body {
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-wrapper {
            flex: 1 0 auto;
        }
        
        .admin-footer {
            flex-shrink: 0;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">
    <!-- Navigation horizontale -->
    @include('layouts.partials.admin-nav-horizontal')
    
    <!-- Wrapper principal pour contenu -->
    <div class="main-wrapper">
        <!-- Contenu principal -->
        <div class="container-fluid">
            <main class="py-4">
                <!-- Titre de page -->
                <div class="mb-4">
                    <h2 class="mb-1">@yield('page-title', 'Administration')</h2>
                    <p class="text-muted mb-0">@yield('page-description', 'Gestion du contenu et des utilisateurs')</p>
                </div>
                
                <!-- Messages flash -->
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
                
                <!-- Contenu de la page -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Footer admin -->
    @include('layouts.partials.admin-footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Quill.js -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{ asset('js/quill-advanced.js') }}"></script>
    
    <!-- Selecteur de medias -->
    <script src="{{ asset('js/media-selector.js') }}"></script>

    @stack('scripts')
</body>
</html>