<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultRolesSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $this->command->info('Adaptation du systÃ¨me de rôles existant...');
            
            // Afficher l'Ã©tat actuel
            $this->showCurrentState();

            // 1. Ajuster les niveaux des rôles existants
            $this->adjustExistingRolesLevels();

            // 2. CrÃ©er le rôle visitor
            $this->createVisitorRole();

            // 3. Ajouter les permissions de visibilitÃ©
            $this->createVisibilityPermissions();

            // 4. RÃ©organiser les permissions par rôle
            $this->assignVisibilityPermissions();

            // 5. Mettre visitor comme rôle par dÃ©faut
            $this->setVisitorAsDefault();

            DB::commit();
            
            $this->command->info('SystÃ¨me de visibilitÃ© configurÃ© avec succÃ¨s !');
            $this->showFinalState();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Erreur lors de la configuration : ' . $e->getMessage());
            throw $e;
        }
    }

    private function showCurrentState()
    {
        $this->command->info('Ã©tat actuel :');
        Role::orderBy('level')->get()->each(function($role) {
            $usersCount = $role->users()->count();
            $defaultMarker = $role->is_default ? ' (PAR DÃ©FAUT)' : '';
            $this->command->info('  - ' . $role->name . ' (niveau ' . $role->level . ')' . $defaultMarker . ' - ' . $usersCount . ' utilisateur(s)');
        });
    }

    private function adjustExistingRolesLevels()
    {
        $this->command->info('RÃ©organisation des niveaux de rôles...');

        // Nouvelle hiÃ©rarchie: visitor(1) < user(10) < editor(50) < admin(100)
        $roleUpdates = [
            'Admin' => [
                'level' => 100, 
                'name' => 'admin', 
                'slug' => 'admin',
                'description' => 'AccÃ¨s complet au systÃ¨me avec gestion des utilisateurs'
            ],
            'Editor' => [
                'level' => 50, 
                'name' => 'editor', 
                'slug' => 'editor',
                'description' => 'RÃ©dacteur pouvant crÃ©er et modifier du contenu'
            ],
            'User' => [
                'level' => 10, 
                'name' => 'user', 
                'slug' => 'user',
                'description' => 'Utilisateur vÃ©rifiÃ© avec accÃ¨s au contenu premium'
            ],
        ];

        foreach ($roleUpdates as $oldName => $updates) {
            $role = Role::where('name', $oldName)->first();
            if ($role) {
                $role->update($updates);
                $this->command->info('  ✓ ' . $oldName . ' -> niveau ' . $updates['level'] . ' (nom: ' . $updates['name'] . ')');
            }
        }
    }

    private function createVisitorRole()
    {
        $this->command->info('CrÃ©ation du rôle Visitor...');

        $visitorData = [
            'name' => 'visitor',
            'slug' => 'visitor',
            'display_name' => 'Visiteur',
            'description' => 'Utilisateur nouvellement inscrit avec accÃ¨s limitÃ© au contenu public uniquement',
            'level' => 1,
            'is_default' => false,
        ];

        $visitor = Role::firstOrCreate(
            ['name' => 'visitor'],
            $visitorData
        );

        if ($visitor->wasRecentlyCreated) {
            $this->command->info('  ✓ Rôle Visiteur crÃ©Ã© (niveau 1)');
        } else {
            $visitor->update($visitorData);
            $this->command->info('  ✓ Rôle Visiteur mis Ã jour');
        }
    }

    private function createVisibilityPermissions()
    {
        $this->command->info('Ajout des permissions de visibilitÃ©...');

        $newPermissions = [
            [
                'name' => 'view.public.content',
                'slug' => Str::slug('view.public.content'),
                'display_name' => 'Voir le contenu public',
                'description' => 'AccÃ¨s au contenu public du site (intro, mÃ©tadonnÃ©es)',
                'group' => 'content'
            ],
            [
                'name' => 'view.premium.content',
                'slug' => Str::slug('view.premium.content'),
                'display_name' => 'Voir le contenu premium',
                'description' => 'AccÃ¨s au contenu complet des articles restreints',
                'group' => 'content'
            ],
            [
                'name' => 'profile.edit',
                'slug' => Str::slug('profile.edit'),
                'display_name' => 'Modifier son profil',
                'description' => 'Modifier ses informations personnelles',
                'group' => 'profile'
            ],
            [
                'name' => 'admin.access',
                'slug' => Str::slug('admin.access'),
                'display_name' => 'AccÃ¨s administration',
                'description' => 'AccÃ¨s au panel d\'administration',
                'group' => 'admin'
            ]
        ];

        $created = 0;
        foreach ($newPermissions as $permissionData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                $permissionData
            );
            
            if ($permission->wasRecentlyCreated) {
                $created++;
                $this->command->info('  ✓ Permission crÃ©Ã©e : ' . $permission->name);
            }
        }

        // Mettre Ã jour les permissions existantes avec display_name et slug manquants
        $existingPermissions = Permission::whereIn('name', ['Manage Users', 'Manage Posts', 'Manage Categories'])->get();
        
        foreach ($existingPermissions as $permission) {
            $updates = [];
            
            if (!$permission->display_name) {
                $displayNames = [
                    'Manage Users' => 'GÃ©rer les utilisateurs',
                    'Manage Posts' => 'GÃ©rer les articles',
                    'Manage Categories' => 'GÃ©rer les catÃ©gories'
                ];
                $updates['display_name'] = $displayNames[$permission->name] ?? $permission->name;
            }
            
            if (!$permission->slug) {
                $updates['slug'] = Str::slug($permission->name);
            }
            
            if (!empty($updates)) {
                $permission->update($updates);
                $this->command->info('  ✓ Permission mise Ã jour : ' . $permission->name);
            }
        }

        $this->command->info('  ✓ ' . $created . ' nouvelles permissions ajoutÃ©es');
    }

    private function assignVisibilityPermissions()
    {
        $this->command->info('Attribution des permissions par rôle...');

        $rolePermissions = [
            'visitor' => [
                'view.public.content',
                'profile.edit'
            ],
            'user' => [
                'view.public.content',
                'view.premium.content',
                'profile.edit'
            ],
            'editor' => [
                'view.public.content',
                'view.premium.content',
                'profile.edit',
                'Manage Posts',
                'Manage Categories'
            ],
            'admin' => [
                'view.public.content',
                'view.premium.content',
                'profile.edit',
                'Manage Posts',
                'Manage Categories',
                'Manage Users',
                'admin.access'
            ]
        ];

        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = Role::where('name', $roleName)->first();
            if (!$role) {
                $this->command->warn('  ⚠ Rôle ' . $roleName . ' non trouvÃ©');
                continue;
            }

            $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id');
            $role->permissions()->sync($permissionIds);
            
            $this->command->info('  ✓ ' . $role->display_name . ' : ' . $permissionIds->count() . ' permissions');
        }
    }

    private function setVisitorAsDefault()
    {
        $this->command->info('Configuration du rôle par dÃ©faut...');

        // Retirer le dÃ©faut de tous les rôles
        Role::where('is_default', true)->update(['is_default' => false]);

        // Mettre visitor en dÃ©faut
        $visitor = Role::where('name', 'visitor')->first();
        if ($visitor) {
            $visitor->update(['is_default' => true]);
            $this->command->info('  ✓ Visiteur dÃ©fini comme rôle par dÃ©faut pour les nouvelles inscriptions');
        }
    }

    private function showFinalState()
    {
        $this->command->info('');
        $this->command->info('=== SYSTÃ¨ME DE VISIBILITÃ© CONFIGURÃ© ===');
        
        Role::with('permissions')->orderBy('level')->get()->each(function($role) {
            $permissionsCount = $role->permissions->count();
            $usersCount = $role->users()->count();
            $defaultMarker = $role->is_default ? ' [DÃ©FAUT]' : '';
            
            $this->command->info($role->display_name . ' (niveau ' . $role->level . ')' . $defaultMarker);
            $this->command->info('   └─ ' . $permissionsCount . ' permissions | ' . $usersCount . ' utilisateur(s)');
            
            // Montrer les permissions de visibilitÃ©
            $visibilityPerms = $role->permissions->whereIn('name', ['view.public.content', 'view.premium.content']);
            if ($visibilityPerms->count() > 0) {
                $this->command->info('   └─ VisibilitÃ© : ' . $visibilityPerms->pluck('display_name')->implode(', '));
            }
        });

        $this->command->info('');
        $this->command->info('RÃ¨GLES DE VISIBILITÃ© :');
        $this->command->info('   • VISITOR : Voit intro/titre des articles, contenu public uniquement');
        $this->command->info('   • USER+ : Voit le contenu complet des articles premium');
        $this->command->info('   • ADMIN : Peut promouvoir visitor → user pour dÃ©bloquer le contenu');

        $totalUsers = User::count();
        $usersWithoutRole = User::whereNull('role_id')->count();
        
        $this->command->info('');
        $this->command->info('Utilisateurs : ' . $totalUsers . ' total, ' . $usersWithoutRole . ' sans rôle');
        
        if ($usersWithoutRole > 0) {
            $this->command->warn('ATTENTION : ' . $usersWithoutRole . ' utilisateur(s) sans rôle. Les futurs inscrits auront automatiquement le rôle Visiteur.');
        }
    }
}