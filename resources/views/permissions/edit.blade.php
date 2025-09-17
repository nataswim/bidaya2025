@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la permission</h1>

    <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf @method('PUT')
        @include('permissions.partials.form', ['permission' => $permission])
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
