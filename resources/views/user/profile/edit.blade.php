<x-app-layout>
    <x-slot name="header">
        <h2>edit profile</h2>
    </x-slot>
    <p>Bienvenue {{ Auth::user()->name }}</p>
</x-app-layout>