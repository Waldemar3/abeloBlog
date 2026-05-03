<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CategoryService;

final class HomeController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
        parent::__construct();
    }

    public function index(array $params = []): void
    {
        $this->render('home/index', [
            'categories' => $this->categoryService->getWithLatestArticles(3),
        ]);
    }
}
