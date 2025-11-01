@extends('layouts.public')

@section('title', 'Vidéos')
@section('meta_description', 'Découvrez notre bibliothèque de vidéos d\'entraînement, de techniques et de conseils sportifs')

@section('content')
<!-- Section titre -->
<section class="py-5 bg-primary text-white text-center" style="background: linear-gradient(58deg, #04adb9 0%, #4b0055 100%);border-top: 20px solid #71287c;border-left: 20px solid #f9f5f4;border-right: 20px solid #f9f5f4;border-bottom: 20px double rgb(249 245 244);border-radius: 0px 0px 60px 60px;margin-top: 20px;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold d-flex align-items-center justify-content-center gap-3 mb-3">
                    Bibliothèque Vidéo
                </h1>
                <p class="lead mb-0 text-center">
                    <strong>Vidéo</strong>infos, tutoriels, techniques et plus
                </p>

            </div>
        </div>
    </div>
</section>




<!-- Vidéos en vedette -->
@if($featuredVideos->count() > 0)
<section class="py-5 bg-light">
    <div class="container">

        <div class="row g-4">
            @foreach($featuredVideos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-lg hover-lift">
                    @if($video->thumbnail)
                    <div class="position-relative">
                        <img src="{{ $video->thumbnail }}"
                            class="card-img-top"
                            style="height: 220px; object-fit: cover;"
                            alt="{{ $video->title }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-play text-white fs-4"></i>
                            </div>
                        </div>
                        @if($video->duration)
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                            {{ $video->getFormattedDuration() }}
                        </span>
                        @endif
                    </div>
                    @else
                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center"
                        style="height: 220px;">
                        <i class="fas fa-video fa-4x text-white opacity-50"></i>
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($video->categories->take(2) as $category)
                            <span class="badge bg-primary">
                                {{ $category->name }}
                            </span>
                            @endforeach

                            @if($video->visibility === 'authenticated')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                            @endif

                            @if($video->is_featured)
                            <span class="badge bg-success">
                                <i class="fas fa-star me-1"></i>Vedette
                            </span>
                            @endif
                        </div>

                        <h5 class="card-title mb-3">{{ $video->title }}</h5>

                        @if($video->description)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($video->description), 120) }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ number_format($video->views_count) }} vues
                            </small>
                            <a href="{{ route('public.videos.show', $video) }}"
                                class="btn btn-sm btn-primary">
                                Regarder <i class="fas fa-play ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Navigation par Catégories -->
<section class="py-5 {{ $featuredVideos->count() > 0 ? 'bg-white' : 'bg-light' }}">
    <div class="container">
        <div class="text-center mb-5">
            <p class="lead text-muted">
                Choisissez la thématique qui vous intéresse
            </p>
        </div>

        @if($categories->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($categories as $category)
            <div class="col-lg-6">
                <a href="{{ route('public.videos.category', $category) }}"
                    class="text-decoration-none">
                    <div class="card h-100 shadow-lg border-0 bg-white hover-lift category-card">
                        <div class="card-header {{ $loop->index % 4 == 0 ? 'bg-primary' : ($loop->index % 4 == 1 ? 'bg-success' : ($loop->index % 4 == 2 ? 'bg-info' : 'bg-warning')) }} text-white">
                            <div class="d-flex align-items-center">
                                @if($category->image)
                                <img src="{{ $category->image }}"
                                    class="rounded me-3"
                                    style="width: 60px; height: 60px; object-fit: cover;"
                                    alt="{{ $category->name }}">
                                @else
                                <i class="fas fa-folder me-3" style="font-size: 2.5rem;"></i>
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $category->name }}</h4>
                                    <p class="mb-0 opacity-75">{{ $category->published_videos_count }} vidéo(s)</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if($category->description)
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($category->description, 150) }}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">Voir les vidéos →</span>
                                <span class="badge bg-primary fs-6">
                                    {{ $category->published_videos_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Toutes les vidéos -->
        @if($videos->count() > 0)
        <div class="border-top pt-5">
            <h3 class="mb-4">Toutes les vidéos</h3>
            <div class="row g-4">
                @foreach($videos as $video)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow hover-lift">
                        @if($video->thumbnail)
                        <div class="position-relative">
                            <img src="{{ $video->thumbnail }}"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $video->title }}">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div class="bg-danger bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-play text-white fs-5"></i>
                                </div>
                            </div>
                            @if($video->duration)
                            <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark">
                                {{ $video->getFormattedDuration() }}
                            </span>
                            @endif

                            {{-- Badge Premium --}}
                            @if($video->visibility === 'authenticated')
                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                <i class="fas fa-crown me-1"></i>Premium
                            </span>
                            @endif
                        </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($video->title, 60) }}</h5>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>{{ number_format($video->views_count) }}
                                </small>
                                <a href="{{ route('public.videos.show', $video) }}"
                                    class="btn btn-sm btn-primary">
                                    Regarder
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($videos->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $videos->links() }}
            </div>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .category-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .category-card:hover {
        border-left-color: var(--bs-primary);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
    }
</style>
@endpush