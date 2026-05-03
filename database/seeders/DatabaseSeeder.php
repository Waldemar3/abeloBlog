<?php

declare(strict_types=1);

namespace Database\Seeders;

final class DatabaseSeeder extends BaseSeeder
{
    private const SEEDERS = [
        CategorySeeder::class,
        ArticleSeeder::class,
    ];

    public function run(): void
    {
        foreach (self::SEEDERS as $seederClass) {
            (new $seederClass())->run();
        }
    }
}
