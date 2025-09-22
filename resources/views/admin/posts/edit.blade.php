@extends('layouts.admin')

@section('title', 'Modifier un article')
@section('page-title', 'Modifier l\'article')
@section('page-description', 'Modification de l\'article : ' . $post->name)

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.posts.update', $post) }}">
        @method('PUT')
        @include('admin.posts.partials.form', [
            'submitLabel' => 'Mettre à jour l\'article',
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ])
    </form>
</div>
@endsection

@push('styles')
<style>
.max-height-200 {
    max-height: 200px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #10b981 100%);
}
</style>
@endpush

