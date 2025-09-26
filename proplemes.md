
images liens symbolique 
Ce problème arrive souvent avec les systèmes de déploiement automatique qui créent des dossiers temporaires. Le lien symbolique doit être recréé à chaque déploiement pour pointer vers le bon dossier.
## 🎯 **Problème identifié !**

Le problème vient du **lien symbolique cassé**.  lien symbolique pointe vers un dossier de déploiement temporaire qui n'existe plus :

```bash
public/storage -> /home/elha2196/nataswim.fr/temp_deploy/storage/app/public
```

## 🔧 **Solution complète**

### 1. **Supprimer le lien symbolique cassé**
```bash
cd /home/elha2196/nataswim.fr/current
rm public/storage
```

### 2. **Recréer le lien symbolique correct**
```bash
# Méthode 1 : Via Artisan (recommandée)
php artisan storage:link

# OU Méthode 2 : Manuellement si Artisan ne fonctionne pas
ln -s ../storage/app/public public/storage
```

### 3. **Vérifier le nouveau lien**
```bash
ls -la public/storage
# Devrait afficher : public/storage -> ../storage/app/public
```

### 4. **Vérifier que les fichiers sont accessibles**
```bash
ls -la public/storage/media/
# Devrait lister vos images
```

### 5. **Vérifier les permissions**
```bash
chmod -R 755 storage/app/public
chmod -R 755 public/storage
```

### 6. **Tester l'accès**
Testez à nouveau cette URL :
```
https://nataswim.fr/storage/media/2025-09-25_16-29-10_zUMrGhsc.png
```

## 🚨 **Si le problème persiste**

Si après ces étapes l'image ne s'affiche toujours pas, ajoutez cette vérification dans votre modèle `Media.php` :

**Remplacez la méthode `getUrlAttribute()` par :**

```php
// app/Models/Media.php

/**
 * URL publique du fichier
 */
public function getUrlAttribute()
{
    // Pour le debug en production
    $storagePath = $this->path;
    $fullPath = Storage::disk('public')->path($storagePath);
    
    // Log pour debug si nécessaire
    if (config('app.debug')) {
        \Log::info('Media URL Debug', [
            'path' => $this->path,
            'full_path' => $fullPath,
            'exists' => Storage::disk('public')->exists($this->path),
            'app_url' => config('app.url')
        ]);
    }
    
    // Vérifier que le fichier existe
    if (Storage::disk('public')->exists($this->path)) {
        return config('app.url') . '/storage/' . $this->path;
    }
    
    // Retourner une URL par défaut si le fichier n'existe pas
    return config('app.url') . '/storage/default-image.jpg';
}
```

**Exécutez ces commandes dans l'ordre  !**