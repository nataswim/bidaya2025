<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n’avez pas reçu l’e-mail, nous vous en enverrons un autre.') }}
    </div>

    @if (session('status') == 'verification-link-sent