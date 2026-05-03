<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'AbeloBlog',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
        'url' => $_ENV['APP_URL'] ?? 'http://localhost:8080',
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'db',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'name' => $_ENV['DB_NAME'] ?? 'abelo_blog',
        'user' => $_ENV['DB_USER'] ?? 'blog_user',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
    ],
    'smarty' => [
        'template_dir' => dirname(__DIR__, 2) . '/templates',
        'compile_dir' => dirname(__DIR__, 2) . '/var/compiled_templates',
        'cache_dir' => dirname(__DIR__, 2) . '/var/cache',
        'caching' => false,
    ],
    'pagination' => [
        'per_page' => (int) ($_ENV['PAGINATION_PER_PAGE'] ?? 6),
    ],
];
