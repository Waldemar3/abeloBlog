<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\Exception\NotFoundException;
use App\Core\Pagination;
use App\Models\Article;

final class ArticleService
{
    public function __construct(private readonly Article $article) {}

    public function getBySlug(string $slug): array
    {
        $article = $this->article->findBySlug($slug);

        if ($article === false) {
            throw new NotFoundException("Article not found: {$slug}");
        }

        return $article;
    }

    public function getPaginatedByCategory(int $categoryId, string $sort, int $page): array
    {
        $perPage = Config::get('pagination.per_page', 6);
        $total = $this->article->countByCategory($categoryId);
        $pagination = new Pagination($total, $perPage, $page);

        return [
            'items' => $this->article->findByCategory(
                $categoryId,
                $sort,
                $pagination->perPage,
                $pagination->offset
            ),
            'pagination' => $pagination->toArray(),
        ];
    }

    public function getSimilar(int $articleId, array $categoryIds, int $limit = 3): array
    {
        return $this->article->findSimilar($articleId, $categoryIds, $limit);
    }

    public function incrementViews(int $articleId): void
    {
        $this->article->incrementViews($articleId);
    }
}
