<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function __construct(private readonly Container $container) {}

    public function get(string $pattern, array $handler): void
    {
        $this->routes[] = [
            'method' => 'GET',
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = $this->normalizeUri($uri);

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $params = $this->match($route['pattern'], $uri);

            if ($params !== null) {
                [$controllerClass, $action] = $route['handler'];
                $this->container->make($controllerClass)->$action($params);
                return;
            }
        }

        $this->handleNotFound();
    }

    private function match(string $pattern, string $uri): ?array
    {
        $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $uri, $matches)) {
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }

        return null;
    }

    private function normalizeUri(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = '/' . trim($path ?? '', '/');

        return $path === '//' ? '/' : $path;
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        (new View())->render('errors/404');
    }
}
