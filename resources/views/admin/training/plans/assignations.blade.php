@extends('layouts.admin')

@section('title', 'Assignations du plan')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Utilisateurs assignés -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-users me-2"></i>Utilisateurs Assignés
                            </h5>
                            <small class="opacity-75">Plan : {{ $plan->titre }}</small>
                        </div>
                        <span class="badge bg-light text-dark fs-6">
                            {{ $plan->users->count() }} utilisateur(s)
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($plan->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">Utilisateur</th>
                                        <th class="px-4 py-3">Statut</th>
                                        <th class="px-4 py-3">Progression</th>
                                        <th class="px-4 py-3">Dates</th>
                                        <th class="px-4 py-3 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plan->users as $user)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <span class="badge bg-{{ $user->pivot->statut_color }}-subtle text-{{ $user->pivot->statut_color }}">
                                                    {{ $user->pivot->statut_label }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                @if($user->pivot->progression_pourcentage > 0)
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress me-2" style="width: 80px; height: 6px;">
                                                            <div class="progress-bar bg-{{ $user->pivot->statut_color }}" 
                                                                 style="width: {{ $user->pivot->progression_pourcentage }}%"></div>
                                                        </div>
                                                        <small>{{ $user->pivot->progression_pourcentage }}%</small>
                                                    </div>
                                                @else
                                                    <small class="text-muted">Non commencé</small>
                                                @endif
                                            </td>
                                            
                                            <td class="px-4 py-3">
                                                <div class="small">
                                                    @if($user->pivot->date_debut)
                                                        <div>Début: {{ \Carbon\Carbon::parse($user->pivot->date_debut)->format('d/m/Y') }}</div>
                                                    @endif
                                                    @if($user->pivot->date_fin_prevue)
                                                        <div class="text-muted">Fin prévue: {{ \Carbon\Carbon::parse($user->pivot->date_fin_prevue)->format('d/m/Y') }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-4 py-3 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" 
                                                            data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button type="button" 
                                                                    class="dropdown-item" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editModal{{ $user->id }}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </button>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" 
                                                                  action="{{ route('admin.training.plans.unassign-user', [$plan, $user]) }}" 
                                                                  onsubmit="return confirm('Retirer ce plan de cet utilisateur ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times me-2"></i>Retirer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal d'édition -->
                                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('admin.training.plans.update-assignation', [$plan, $user]) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier l'assignation - {{ $user->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Statut</label>
                                                                <select name="statut" class="form-select" required>
                                                                    <option value="non_commence" {{ $user->pivot->statut === 'non_commence' ? 'selected' : '' }}>Non commencé</option>
                                                                    <option value="en_cours" {{ $user->pivot->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                                                    <option value="pause" {{ $user->pivot->statut === 'pause' ? 'selected' : '' }}>En pause</option>
                                                                    <option value="termine" {{ $user->pivot->statut === 'termine' ? 'selected' : '' }}>Terminé</option>
                                                                    <option value="abandonne" {{ $user->pivot->statut === 'abandonne' ? 'selected' : '' }}>Abandonné</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Progression (%)</label>
                                                                <input type="number" 
                                                                       name="progression_pourcentage" 
                                                                       class="form-control" 
                                                                       value="{{ $user->pivot->progression_pourcentage }}"
                                                                       min="0" max="100" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Notes admin</label>
                                                                <textarea name="notes_admin" 
                                                                          class="form-control" 
                                                                          rows="3">{{ $user->pivot->notes_utilisateur }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>Aucun utilisateur assigné</h5>
                            <p class="text-muted">Ce plan n'est encore assigné à aucun utilisateur.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Assigner un nouvel utilisateur -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Assigner le plan
                    </h6>
                </div>
                <form method="POST" action="{{ route('admin.training.plans.assign-user', $plan) }}">
                    @csrf
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Utilisateur</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">Choisir un utilisateur</option>
                                @foreach($users as $user)
                                    @if(!$plan->isAssignedToUser($user->id))
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" 
                                   name="date_debut" 
                                   id="date_debut" 
                                   class="form-control"
                                   value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label for="notes_admin" class="form-label">Notes</label>
                            <textarea name="notes_admin" 
                                      id="notes_admin" 
                                      rows="3" 
                                      class="form-control"
                                      placeholder="Notes pour cet utilisateur..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>Assigner le plan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informations du plan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white p-3">
                    <h6 class="mb-0">
                        <i class="fas fa-water me-2"></i>Informations du plan
                    </h6>
                </div>
                <div class="card-body p-3">
                    <h6 class="mb-2">{{ $plan->titre }}</h6>
                    <div class="row g-2 small">
                        <div class="col-6">
                            <span class="text-muted">Niveau:</span>
                            <div>{{ $plan->niveau_label }}</div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">Objectif:</span>
                            <div>{{ $plan->objectif_label }}</div>
                        </div>
                        @if($plan->duree_semaines)
                            <div class="col-6">
                                <span class="text-muted">Durée:</span>
                                <div>{{ $plan->duree_semaines_formattee }}</div>
                            </div>
                        @endif
                        <div class="col-6">
                            <span class="text-muted">Cycles:</span>
                            <div>{{ $plan->getTotalCycles() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.training.plans.show', $plan) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Voir le plan
                        </a>
                        <a href="{{ route('admin.training.plans.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour aux plans
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection