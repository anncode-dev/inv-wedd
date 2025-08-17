<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Bisa ubah ke ['http://localhost:3000'] jika hanya untuk frontend tertentu
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];
