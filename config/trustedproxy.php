<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies — en hébergement derrière nginx, Apache, Cloudflare, etc.
    |--------------------------------------------------------------------------
    |
    | Après Laravel 10+, les IP distantes peuvent être vues comme « sans proxy », ce
    | qui fait croire que la connexion est en HTTP : les URLs générées (asset(),
    | route()) restent alors en http:// et cassent CSS/JS sous HTTPS (mixed content).
    |
    | * = faire confiance au client direct pour les entêtes X-Forwarded-* (usage
    |     courant sur hébergement mutualisé). Liste d’IPs possible : 10.0.0.1,10.0.0.2
    | vide ou false = développement local sans reverse proxy uniquement (à ajuster selon infra).
    |
    */

    'proxies' => env('TRUSTED_PROXIES', '*'),

];
