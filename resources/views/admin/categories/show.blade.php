@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la catégorie</h1>

    <table class="table table-bordered">
        @foreach($category->getAttributes() as $field => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
