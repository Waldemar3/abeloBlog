<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\CategoryService;

final class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ArticleService $articleService
    ) {
        parent::__construct();
    }

    public function show(array $params): void
    {
        $category = $this->categoryService->getBySlug($params['slug']);

        $sort = $this->resolveSort();
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $result = $this->articleService->getPaginatedByCategory($category['id'], $sort, $page);

        $this->render('category/show', [
            'category' => $category,
            'articles' => $result['items'],
            'pagination' => $result['pagination'],
            'sort' => $sort,
            'pageTitle' => $category['name'] . ' — ' . Config::get('app.name'),
        ]);
    }

    private function resolveSort(): string
    {
        $sort = $_GET['sort'] ?? Article::SORT_DATE;

        return in_array($sort, [Article::SORT_DATE, Article::SORT_VIEWS], true)
            ? $sort
            : Article::SORT_DATE;
    }
}
