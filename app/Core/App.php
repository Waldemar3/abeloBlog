<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;

final class App
{
    private Router $router;

    public function __construct(array $config)
    {
        Config::load($config);
        Database::getInstance($config['db']);

        $this->router = new Router();
        $this->registerRoutes();
    }

    public function run(): void
    {
        $this->router->dispatch(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
    }

    private function registerRoutes(): void
    {
        $this->router->get('/', [HomeController::class, 'index']);
        $this->router->get('/category/{slug}', [CategoryController::class, 'show']);
        $this->router->get('/article/{slug}', [ArticleController::class, 'show']);
    }
}
