@extends('layouts.admin')

@section('title', 'Gestion des Rôles')
@section('page-title', 'Rôles et Permissions')
@section('page-description', 'Gestion des rôles utilisateurs et permissions')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Liste des rôles -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Rôles du système</h5>
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-shield me-2"></i>Nouveau rôle
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @forelse($roles as $role)
                        <div class="border-bottom p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'user' ? 'primary' : 'info') }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-{{ $role->name === 'admin' ? 'crown' : ($role->name === 'user' ? 'user' : 'user-shield') }} text-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'user' ? 'primary' : 'info') }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $role->display_name }}</h6>
                                            <small class="text-muted">{{ $role->name }}</small>
                                            @if($role->description)
                                                <br><small class="text-muted">{{ $role->description }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ $role->users()->count() }}</h5>
                                        <small class="text-muted">Utilisateurs</small>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($role->name !== 'admin' && $role->name !== 'user')
                                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-confirm="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Permissions du rôle -->
                            @if($role->permissions->count() > 0)
                                <div class="mt-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($role->permissions->take(5) as $permission)
                                            <span class="badge bg-secondary-subtle text-secondary">{{ $permission->display_name }}</span>
                                        @endforeach
                                        @if($role->permissions->count() > 5)
                                            <span class="badge bg-light text-dark">+{{ $role->permissions->count() - 5 }} autres</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-user-shield fa-3x text-muted mb-3"></i>
                            <h5>Aucun rôle configuré</h5>
                            <p class="text-muted">Créez des rôles pour organiser les permissions utilisateurs</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar informations -->
        <div class="col-lg-4">
            <!-- Statistiques -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Répartition des utilisateurs
                    </h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $usersByRole = \App\Models\User::selectRaw('role_id, count(*) as count')
                            ->groupBy('role_id')
                            ->with('role')
                            ->get();
                        $totalUsers = \App\Models\User::count();
                    @endphp
                    
                    @foreach($usersByRole as $stat)
                        @php $percentage = $totalUsers > 0 ? round(($stat->count / $totalUsers) * 100, 1) : 0; @endphp
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <span class="fw-semibold">{{ $stat->role->display_name ?? 'Sans rôle' }}</span>
                                <br><small class="text-muted">{{ $stat->count }} utilisateurs</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $percentage }}%</div>
                                <div class="progress" style="width: 60px; height: 4px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Permissions système -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">
                            <i class="fas fa-key me-2 text-warning"></i>Permissions système
                        </h6>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-warning">
                            Gérer
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        $permissionGroups = \App\Models\Permission::selectRaw('SUBSTRING_INDEX(name, ".", 1) as group_name, count(*) as count')
                            ->groupBy('group_name')
                            ->get();
                    @endphp
                    
                    @foreach($permissionGroups as $group)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-capitalize">{{ str_replace('_', ' ', $group->group_name) }}</span>
                            <span class="badge bg-light text-dark">{{ $group->count }}</span>
                        </div>
                    @endforeach
                    
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            Total: {{ \App\Models\Permission::count() }} permissions
                        </small>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-tools me-2 text-info"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="syncPermissions()">
                            <i class="fas fa-sync me-2"></i>Synchroniser les permissions
                        </button>
                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#assignRoleModal">
                            <i class="fas fa-user-plus me-2"></i>Assigner un rôle
                        </button>
                        <button class="btn btn-outline-success" onclick="exportRoles()">
                            <i class="fas fa-download me-2"></i>Exporter la configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal assignation rôle -->
<div class="modal fade" id="assignRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Assigner un rôle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.assign-role') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-semibold">Utilisateur</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label fw-semibold">Rôle</label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Assigner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function syncPermissions() {
    if (confirm('Synchroniser les permissions avec le code source ?')) {
        fetch('{{ route("admin.permissions.sync") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${data.created} permissions créées, ${data.updated} mises à jour`);
                location.reload();
            }
        });
    }
}

function exportRoles() {
    window.open('{{ route("admin.roles.export") }}', '_blank');
}
</script>
@endpush