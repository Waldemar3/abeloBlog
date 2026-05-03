<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = require dirname(__DIR__) . '/app/Config/config.php';

use App\Core\Database;
use Database\Seeders\DatabaseSeeder;

$db = Database::getInstance($config['db']);

if (in_array('--if-empty', $argv ?? [], true)) {
    $row = $db->fetch('SELECT COUNT(*) AS cnt FROM articles');
    if ((int) ($row['cnt'] ?? 0) > 0) {
        exit(0);
    }
}

(new DatabaseSeeder())->run();
