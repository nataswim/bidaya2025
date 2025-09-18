<x-app-layout>
    <x-slot name="header">
        <h2>Mon espace</h2>
    </x-slot>
    <p>Bienvenue {{ Auth::user()->name }}</p>
</x-app-layout>