@extends('layouts.user')

@section('title', 'Liste des utilisateurs')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Liste des utilisateurs</h1>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Nom</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users ?? [] as $user)
                <tr>
                    <td class="border p-2">{{ $user->name }}</td>
                    <td class="border p-2">{{ $user->email }}</td>
                    <td class="border p-2">
                        <a href="{{ route('user.show', $user->id) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
