<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\Database;

abstract class BaseSeeder
{
    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    abstract public function run(): void;
}
