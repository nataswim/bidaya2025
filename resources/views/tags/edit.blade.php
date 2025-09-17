@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le tag</h1>

    <form action="{{ route('tags.update', $tag) }}" method="POST">
        @csrf @method('PUT')
        @include('tags.partials.form', ['tag' => $tag])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
