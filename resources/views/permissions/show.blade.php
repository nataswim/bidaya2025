@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la permission</h1>

    <table class="table table-bordered">
        @foreach($permission->getAttributes() as $field => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
