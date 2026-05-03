<?php

declare(strict_types=1);

namespace App\Models;

final class Category extends BaseModel
{
    public function findBySlug(string $slug): array|false
    {
        return $this->db->fetch(
            'SELECT * FROM categories WHERE slug = ?',
            [$slug]
        );
    }

    public function findWithLatestArticles(int $limit = 3): array
    {
        $categories = $this->db->fetchAll(
            'SELECT DISTINCT c.*
             FROM categories c
             INNER JOIN article_categories ac ON c.id = ac.category_id
             ORDER BY c.name'
        );

        foreach ($categories as &$category) {
            $category['articles'] = $this->db->fetchAll(
                'SELECT a.*
                 FROM articles a
                 INNER JOIN article_categories ac ON a.id = ac.article_id
                 WHERE ac.category_id = ?
                 ORDER BY a.published_at DESC
                 LIMIT ?',
                [$category['id'], $limit]
            );
        }
        unset($category);

        return $categories;
    }
}
