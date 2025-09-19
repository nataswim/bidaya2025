@extends('layouts.admin')

@section('title', 'Modifier mon profil')

@section('content')
    <div class="space-y-6">
        @include('admin.profile.partials.update-profile-information-form', ['user' => $user])
        @include('admin.profile.partials.update-password-form')
        @include('admin.profile.partials.delete-user-form')
    </div>
@endsection
