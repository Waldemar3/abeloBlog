<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

final class HomeController extends Controller
{
    private Category $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    public function index(array $params = []): void
    {
        $this->render('home/index', [
            'categories' => $this->categoryModel->findWithLatestArticles(3),
        ]);
    }
}
