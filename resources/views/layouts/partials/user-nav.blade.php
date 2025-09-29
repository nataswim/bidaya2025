<nav class="bg-blue-500 text-white p-3">
    <ul class="flex space-x-4">
        <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
        <li><a href="{{ route('user.profile.edit') }}" class="hover:underline">Mon Profil</a></li>
        <!-- Ajoutez cette section après les liens existants -->
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('user.training.*') ? 'active' : '' }}" 
       href="{{ route('user.training.index') }}">
        <i class="fas fa-dumbbell me-2"></i>
        <span>Entraînement</span>
        @if(auth()->user()->hasActivePlan())
            <span class="badge bg-success ms-2">Actif</span>
        @endif
    </a>
</li>
    </ul>
</nav>
