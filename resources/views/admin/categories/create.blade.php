@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une catégorie</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories.partials.form', ['category' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
