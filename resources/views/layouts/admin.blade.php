<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Administration</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        @include('layouts.partials.admin-nav')
        
        <div class="flex-fill d-flex flex-column">
            @include('layouts.partials.admin-header')
            
            <main class="flex-fill p-4">
                <!-- Messages Flash -->
                @if(session('success') || session('error') || session('warning'))
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>