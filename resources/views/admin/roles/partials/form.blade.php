@csrf

<div class="row g-4">
    <!-- Contenu principal -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white p-4">
                <h5 class="mb-0">
                    <i class="fas fa-user-shield me-2"></i>Informations du rôle
                </h5>
            </div>
            <div class="card-body p-4">
                <!-- Nom du rôle -->
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nom du rôle (technique) *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', isset($role) ? $role->name : '') }}"
                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                           placeholder="Ex: editor, moderator, contributor"
                           required>
                    <div class="form-text">Nom technique du rôle (lettres minuscules, underscores autorisés)</div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nom d'affichage -->
                <div class="mb-4">
                    <label for="display_name" class="form-label fw-semibold">Nom d'affichage</label>
                    <input type="text" 
                           name="display_name" 
                           id="display_name" 
                           value="{{ old('display_name', isset($role) ? $role->display_name : '') }}"
                           class="form-control form-control-lg @error('display_name') is-invalid @enderror"
                           placeholder="Ex: Éditeur, Modérateur, Contributeur">
                    <div class="form-text">Nom affiché aux utilisateurs</div>
                    @error('display_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ url('/roles') }}/</span>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', isset($role) ? $role->slug : '') }}"
                               class="form-control @error('slug') is-invalid @enderror"
                               placeholder="editor-role">
                    </div>
                    <div class="form-text">Laisser vide pour génération automatique</div>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Description détaillée du rôle et de ses responsabilités...">{{ old('description', isset($role) ? $role->description : '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>






<!-- Permissions -->
<div class="border-top pt-4">
    <h6 class="fw-semibold mb-3 text-primary">
        <i class="fas fa-key me-2"></i>Permissions
    </h6>
    
    @php
        // Récupérer les permissions directement si pas déjà passées
        if (!isset($permissions) || !$permissions || $permissions->isEmpty()) {
            $permissions = \App\Models\Permission::all();
        }
        
        // Vérifier que $permissions est bien une collection
        if ($permissions && $permissions->count() > 0) {
            // Grouper les permissions par groupe
            $permissionGroups = $permissions->groupBy(function($item) {
                return $item->group ?? 'general';
            });
            
            // Récupérer les permissions du rôle actuel
            $rolePermissions = [];
            if (isset($role) && $role && $role->permissions) {
                $rolePermissions = $role->permissions->pluck('id')->toArray();
            }
        } else {
            $permissionGroups = collect();
            $rolePermissions = [];
        }
    @endphp

    @if($permissionGroups->count() > 0)
        <div class="row g-3">
            @foreach($permissionGroups as $groupName => $groupPermissions)
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header bg-light p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 text-capitalize">
                                    <i class="fas fa-folder me-2 text-info"></i>
                                    {{ str_replace(['_', '-'], ' ', $groupName) }}
                                </h6>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="toggle_{{ $groupName }}"
                                           onclick="toggleGroup('{{ $groupName }}')">
                                    <label class="form-check-label small" for="toggle_{{ $groupName }}">
                                        Tout sélectionner
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            @foreach($groupPermissions as $permission)
                                @if($permission && isset($permission->id) && isset($permission->name))
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox" 
                                               type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="permission_{{ $permission->id }}"
                                               data-group="{{ $groupName }}"
                                               {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            <strong>{{ $permission->name }}</strong>
                                            @if(isset($permission->description) && $permission->description)
                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                            @endif
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @error('permissions')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Aucune permission disponible</strong><br>
            @if(\App\Models\Permission::count() == 0)
                Aucune permission n'a été créée dans le système. 
                <a href="{{ route('admin.permissions.create') }}" class="alert-link">Créer des permissions</a> d'abord.
            @else
                Impossible de charger les permissions. Veuillez vérifier la configuration.
            @endif
        </div>
    @endif
</div>








            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Paramètres du rôle -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-success text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="level" class="form-label fw-semibold">Niveau d'autorité</label>
                    <input type="number" 
                           name="level" 
                           id="level" 
                           value="{{ old('level', isset($role) ? $role->level : 1) }}"
                           class="form-control @error('level') is-invalid @enderror"
                           min="1" 
                           max="100"
                           placeholder="1">
                    <div class="form-text">Plus le niveau est élevé, plus les permissions sont importantes (1-100)</div>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="is_default" 
                           id="is_default" 
                           value="1"
                           {{ old('is_default', isset($role) ? $role->is_default : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">
                        <i class="fas fa-star text-warning me-1"></i>
                        Rôle par défaut
                    </label>
                    <div class="form-text">Attribué automatiquement aux nouveaux utilisateurs</div>
                </div>
            </div>
        </div>

        <!-- Statistiques (en édition) -->
        @if(isset($role))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white p-4">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-primary mb-1">{{ $role->users()->count() }}</h4>
                                <small class="text-muted">Utilisateurs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h4 class="fw-bold text-success mb-1">{{ $role->permissions()->count() }}</h4>
                                <small class="text-muted">Permissions</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Aperçu des permissions sélectionnées -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-warning text-white p-4">
                <h6 class="mb-0">
                    <i class="fas fa-eye me-2"></i>Permissions sélectionnées
                </h6>
            </div>
            <div class="card-body p-4">
                <div id="selected-permissions" class="text-center text-muted">
                    <small>Aucune permission sélectionnée</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ $submitLabel ?? 'Enregistrer' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>