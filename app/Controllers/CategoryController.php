<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Core\Pagination;
use App\Models\Article;
use App\Models\Category;

final class CategoryController extends Controller
{
    private Category $categoryModel;
    private Article $articleModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->articleModel = new Article();
    }

    public function show(array $params): void
    {
        $category = $this->categoryModel->findBySlug($params['slug']);

        if ($category === false) {
            http_response_code(404);
            $this->render('errors/404');
            return;
        }

        $sort = $this->resolveSort();
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = Config::get('pagination.per_page', 6);

        $total = $this->articleModel->countByCategory($category['id']);
        $pagination = new Pagination($total, $perPage, $page);

        $articles = $this->articleModel->findByCategory(
            $category['id'],
            $sort,
            $pagination->perPage,
            $pagination->offset
        );

        $this->render('category/show', [
            'category' => $category,
            'articles' => $articles,
            'pagination' => $pagination->toArray(),
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
