@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la catégorie</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        @include('categories.partials.form', ['category' => $category])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
