<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Récupérer une valeur depuis la base
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = 'setting_' . $key;
        
        return Cache::remember($cacheKey, 3600, function() use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            // Convertir selon le type
            return match($setting->type) {
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'integer' => (int) $setting->value,
                'json' => json_decode($setting->value, true),
                default => $setting->value,
            };
        });
    }

    /**
     * Définir une valeur
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): void
    {
        // Convertir la valeur selon le type
        $valueToStore = match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value,
        };

        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $valueToStore,
                'type' => $type,
                'group' => $group
            ]
        );

        // Vider le cache
        Cache::forget('setting_' . $key);
    }

    /**
     * Récupérer tous les paramètres d'un groupe
     */
    public static function getGroup(string $group): array
    {
        return self::where('group', $group)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }
}