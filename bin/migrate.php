<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = require dirname(__DIR__) . '/app/Config/config.php';

use App\Core\Database;

$db = Database::getInstance($config['db']);
$sql = file_get_contents(dirname(__DIR__) . '/database/migrations/001_create_tables.sql');

foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
    $db->query($statement);
}
