@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une permission</h1>

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        @include('permissions.partials.form', ['permission' => null])
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
