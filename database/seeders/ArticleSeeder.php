<?php

declare(strict_types=1);

namespace Database\Seeders;

use Faker\Factory;

final class ArticleSeeder extends BaseSeeder
{
    private const COUNT = 50;

    private const IMAGES = [
        'https://picsum.photos/seed/blog1/800/450',
        'https://picsum.photos/seed/blog2/800/450',
        'https://picsum.photos/seed/blog3/800/450',
        'https://picsum.photos/seed/blog4/800/450',
        'https://picsum.photos/seed/blog5/800/450',
        'https://picsum.photos/seed/blog6/800/450',
        'https://picsum.photos/seed/blog7/800/450',
        'https://picsum.photos/seed/blog8/800/450',
    ];

    private const TRANSLITERATION = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    ];

    public function run(): void
    {
        $faker = Factory::create('ru_RU');

        $categoryIds = array_column(
            $this->db->fetchAll('SELECT id FROM categories'),
            'id'
        );

        if (empty($categoryIds)) {
            return;
        }

        $this->db->beginTransaction();

        try {
            for ($i = 0; $i < self::COUNT; $i++) {
                $title = $faker->sentence(random_int(4, 8));
                $slug = $this->buildSlug($title, $i);

                $this->db->execute(
                    'INSERT IGNORE INTO articles
                     (title, slug, description, content, image, views, published_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [
                        rtrim($title, '.'),
                        $slug,
                        $faker->paragraph(2),
                        implode("\n\n", $faker->paragraphs(random_int(5, 10))),
                        self::IMAGES[array_rand(self::IMAGES)],
                        $faker->numberBetween(0, 10000),
                        $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
                    ]
                );

                $articleId = (int) $this->db->lastInsertId();

                if ($articleId === 0) {
                    continue;
                }

                $shuffled = $categoryIds;
                shuffle($shuffled);
                $assigned = array_slice($shuffled, 0, random_int(1, 3));

                foreach ($assigned as $categoryId) {
                    $this->db->execute(
                        'INSERT IGNORE INTO article_categories (article_id, category_id) VALUES (?, ?)',
                        [$articleId, $categoryId]
                    );
                }
            }

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    private function buildSlug(string $title, int $suffix): string
    {
        $title = mb_strtolower($title);
        $title = strtr($title, self::TRANSLITERATION);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $title) ?? '';
        $slug = trim($slug, '-');

        return $slug . '-' . $suffix;
    }
}
