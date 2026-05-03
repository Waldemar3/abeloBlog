<?php

declare(strict_types=1);

namespace Database\Seeders;

use Faker\Factory;

final class CategorySeeder extends BaseSeeder
{
    private const CATEGORIES = [
        ['Технологии', 'tekhnologii'],
        ['Наука', 'nauka'],
        ['Путешествия', 'puteshestviya'],
        ['Здоровье', 'zdorovye'],
        ['Спорт', 'sport'],
        ['Культура', 'kultura'],
        ['Бизнес', 'biznes'],
        ['Образование', 'obrazovanie'],
    ];

    public function run(): void
    {
        $faker = Factory::create('ru_RU');

        foreach (self::CATEGORIES as [$name, $slug]) {
            $this->db->execute(
                'INSERT IGNORE INTO categories (name, slug, description) VALUES (?, ?, ?)',
                [$name, $slug, $faker->paragraph(2)]
            );
        }
    }
}
