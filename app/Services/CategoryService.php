<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Exception\NotFoundException;
use App\Models\Category;

final class CategoryService
{
    public function __construct(private readonly Category $category) {}

    public function getBySlug(string $slug): array
    {
        $category = $this->category->findBySlug($slug);

        if ($category === false) {
            throw new NotFoundException("Category not found: {$slug}");
        }

        return $category;
    }

    public function getWithLatestArticles(int $limit = 3): array
    {
        return $this->category->findWithLatestArticles($limit);
    }
}
