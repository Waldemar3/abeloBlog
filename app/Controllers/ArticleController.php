<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Models\Article;

final class ArticleController extends Controller
{
    private Article $articleModel;

    public function __construct()
    {
        parent::__construct();
        $this->articleModel = new Article();
    }

    public function show(array $params): void
    {
        $article = $this->articleModel->findBySlug($params['slug']);

        if ($article === false) {
            http_response_code(404);
            $this->render('errors/404');
            return;
        }

        $this->articleModel->incrementViews($article['id']);
        $article['views']++;

        $categoryIds = array_column($article['categories'], 'id');
        $similar = $this->articleModel->findSimilar($article['id'], $categoryIds, 3);

        $this->render('article/show', [
            'article' => $article,
            'similar' => $similar,
            'pageTitle' => $article['title'] . ' — ' . Config::get('app.name'),
        ]);
    }
}
