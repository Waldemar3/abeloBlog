<?php

declare(strict_types=1);

namespace App\Core;

final class Pagination
{
    public readonly int $total;
    public readonly int $perPage;
    public readonly int $currentPage;
    public readonly int $totalPages;
    public readonly int $offset;

    public function __construct(int $total, int $perPage, int $currentPage)
    {
        $this->total = $total;
        $this->perPage = max(1, $perPage);
        $this->currentPage = max(1, $currentPage);
        $this->totalPages = (int) ceil($total / $this->perPage);
        $this->offset = ($this->currentPage - 1) * $this->perPage;
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'offset' => $this->offset,
            'has_previous' => $this->currentPage > 1,
            'has_next' => $this->currentPage < $this->totalPages,
        ];
    }
}
