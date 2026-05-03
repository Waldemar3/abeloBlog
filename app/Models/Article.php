<?php

declare(strict_types=1);

namespace App\Models;

final class Article extends BaseModel
{
    public const SORT_DATE = 'published_at';
    public const SORT_VIEWS = 'views';

    private const ALLOWED_SORT_COLUMNS = [
        self::SORT_DATE,
        self::SORT_VIEWS,
    ];

    public function findBySlug(string $slug): array|false
    {
        $article = $this->db->fetch(
            'SELECT * FROM articles WHERE slug = ?',
            [$slug]
        );

        if ($article !== false) {
            $article['categories'] = $this->db->fetchAll(
                'SELECT c.*
                 FROM categories c
                 INNER JOIN article_categories ac ON c.id = ac.category_id
                 WHERE ac.article_id = ?',
                [$article['id']]
            );
        }

        return $article;
    }

    public function findByCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        $column = $this->resolveSort($sort);

        return $this->db->fetchAll(
            "SELECT a.*
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id = ?
             ORDER BY a.{$column} DESC
             LIMIT ? OFFSET ?",
            [$categoryId, $limit, $offset]
        );
    }

    public function countByCategory(int $categoryId): int
    {
        $row = $this->db->fetch(
            'SELECT COUNT(*) AS cnt
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id = ?',
            [$categoryId]
        );

        return (int) ($row['cnt'] ?? 0);
    }

    public function findSimilar(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $params = [...$categoryIds, $articleId, $limit];

        return $this->db->fetchAll(
            "SELECT DISTINCT a.*
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id IN ({$placeholders})
             AND a.id != ?
             ORDER BY a.published_at DESC
             LIMIT ?",
            $params
        );
    }

    public function incrementViews(int $articleId): void
    {
        $this->db->execute(
            'UPDATE articles SET views = views + 1 WHERE id = ?',
            [$articleId]
        );
    }

    private function resolveSort(string $sort): string
    {
        return in_array($sort, self::ALLOWED_SORT_COLUMNS, true) ? $sort : self::SORT_DATE;
    }
}
