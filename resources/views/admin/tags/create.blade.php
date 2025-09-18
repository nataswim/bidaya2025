@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un tag</h1>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        @include('tags.partials.form', ['tag' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
