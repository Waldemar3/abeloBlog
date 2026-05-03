<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Core\Exception\NotFoundException;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use App\Services\CategoryService;

final class App
{
    private Container $container;
    private Router $router;

    public function __construct(array $config)
    {
        Config::load($config);
        Database::getInstance($config['db']);

        $this->container = new Container();
        $this->registerBindings();

        $this->router = new Router($this->container);
        $this->registerRoutes();
    }

    public function run(): void
    {
        try {
            $this->router->dispatch(
                $_SERVER['REQUEST_METHOD'],
                $_SERVER['REQUEST_URI']
            );
        } catch (NotFoundException) {
            http_response_code(404);
            (new View())->render('errors/404');
        }
    }

    private function registerBindings(): void
    {
        $this->container->singleton(Article::class, Article::class);
        $this->container->singleton(Category::class, Category::class);

        $this->container->singleton(ArticleService::class, ArticleService::class);
        $this->container->singleton(CategoryService::class, CategoryService::class);
    }

    private function registerRoutes(): void
    {
        $this->router->get('/', [HomeController::class, 'index']);
        $this->router->get('/category/{slug}', [CategoryController::class, 'show']);
        $this->router->get('/article/{slug}', [ArticleController::class, 'show']);
    }
}
