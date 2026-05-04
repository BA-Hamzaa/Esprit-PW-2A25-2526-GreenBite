<?php
/**
 * Résolution des URLs d’images uploadées + fallback si le fichier n’existe pas (seeds SQL avec noms fictifs).
 */
if (!function_exists('gb_uploads_abs_dir')) {
    function gb_uploads_abs_dir(): string
    {
        return BASE_PATH . '/app/views/public/assets/images/uploads';
    }
}

if (!function_exists('gb_fallback_recette')) {
    function gb_fallback_recette(?string $categorie): string
    {
        $map = [
            'Salade' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=900&q=82',
            'Bowl' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=900&q=82',
            'Poisson' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=900&q=82',
            'Pâtes' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?auto=format&fit=crop&w=900&q=82',
            'Petit-déjeuner' => 'https://images.unsplash.com/photo-1494390248081-4e521a5940db?auto=format&fit=crop&w=900&q=82',
        ];
        $c = trim((string) $categorie);
        return $map[$c] ?? 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=900&q=82';
    }
}

if (!function_exists('gb_fallback_produit')) {
    function gb_fallback_produit(?string $categorie): string
    {
        $map = [
            'Légumes' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=900&q=82',
            'Boulangerie' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=82',
            'Produits laitiers' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?auto=format&fit=crop&w=900&q=82',
            'Épicerie' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=900&q=82',
        ];
        $c = trim((string) $categorie);
        return $map[$c] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=82';
    }
}

if (!function_exists('gb_media_url')) {
    /**
     * URL finale pour affichage : fichier local si présent, sinon URL absolue déjà en BDD, sinon placeholder.
     *
     * @param string|null $stored Valeur colonne image (nom fichier ou URL)
     * @param string        $fallback URL photo de repli (Unsplash)
     */
    function gb_media_url(?string $stored, string $fallback): string
    {
        $stored = trim((string) $stored);
        if ($stored !== '' && preg_match('#^https?://#i', $stored)) {
            return $stored;
        }
        if ($stored !== '') {
            $name = basename(str_replace('\\', '/', $stored));
            $path = gb_uploads_abs_dir() . DIRECTORY_SEPARATOR . $name;
            if (is_file($path)) {
                return rtrim(BASE_URL, '/') . '/assets/images/uploads/' . rawurlencode($name);
            }
        }
        return $fallback;
    }
}
