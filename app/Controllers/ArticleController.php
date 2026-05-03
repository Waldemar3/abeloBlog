<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\ArticleService;

final class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $articleService)
    {
        parent::__construct();
    }

    public function show(array $params): void
    {
        $article = $this->articleService->getBySlug($params['slug']);

        $this->articleService->incrementViews($article['id']);
        $article['views']++;

        $categoryIds = array_column($article['categories'], 'id');
        $similar = $this->articleService->getSimilar($article['id'], $categoryIds, 3);

        $this->render('article/show', [
            'article' => $article,
            'similar' => $similar,
            'pageTitle' => $article['title'] . ' — ' . Config::get('app.name'),
        ]);
    }
}
