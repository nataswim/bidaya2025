@extends('layouts.admin')

@section('title', 'Gestion des permissions')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Permissions</h1>
        <a href="{{ route('permissions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nouvelle permission
        </a>
    </div>

    <table class="w-full border-collapse border border-gray-300 bg-white shadow-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Nom</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
                <tr>
                    <td class="border p-2">{{ $permission->name }}</td>
                    <td class="border p-2">{{ $permission->description }}</td>
                    <td class="border p-2 flex space-x-2">
                        <a href="{{ route('permissions.show', $permission) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('permissions.edit', $permission) }}" class="text-yellow-600 hover:underline">Modifier</a>
                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Supprimer cette permission ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border p-4 text-center text-gray-500">Aucune permission trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
