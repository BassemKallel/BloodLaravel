<?php
return [


    'paths' => ['api/*', 'sanctum/csrf-cookie'], // chemins où CORS est actif

    'allowed_methods' => ['*'], // toutes les méthodes autorisées (GET, POST, PUT, DELETE...)

    'allowed_origins' => ['http://localhost:8081'], // autoriser ton frontend ici

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // tous les headers autorisés

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // mettre true si tu utilises les cookies (ex: Sanctum)
];
