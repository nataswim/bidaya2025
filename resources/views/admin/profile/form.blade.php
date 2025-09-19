@extends('layouts.admin')

@section('title', 'Formulaire profil')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-6">
        @csrf
        @method('PATCH')

        @include('admin.profile.partials.update-profile-information-form', ['user' => $user])
        @include('admin.profile.partials.update-password-form')
    </form>
@endsection
