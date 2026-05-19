<?php

namespace App\Support;

/**
 * URLs publiques pour les fichiers enregistrés sur le disk "public"
 * (`storage/app/public`), servis via `/storage/...`.
 */
final class PublicStorageAsset
{
    /** URL avec asset(), ou null si pas de chemin. */
    public static function url(?string $storedPath): ?string
    {
        if ($storedPath === null || trim((string) $storedPath) === '') {
            return null;
        }

        $path = trim(str_replace('\\', '/', $storedPath), '/');

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        while (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        while (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        return asset('storage/' . $path);
    }
}
