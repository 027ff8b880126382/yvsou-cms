<?php
/**
  @copyright (c) 2025  Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo
  @author Lican Huang
  @created 2025-06-04
* License: Dual Licensed – GPLv3 or Commercial
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* As an alternative to GPLv3, commercial licensing is available for organizations
* or individuals requiring proprietary usage, private modifications, or support.
*
* Contact: yvsoucom@gmail.com
* GPL License: https://www.gnu.org/licenses/gpl-3.0.html
*/

use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$modelsPath = __DIR__ . '/app/Models';
$outputFile = __DIR__ . '/install.sql';
$schema = 'yvsoutest'; // <-- set your schema name here

file_put_contents($outputFile, ""); // Clear file before appending

foreach (glob("$modelsPath/*.php") as $file) {
    require_once $file;

    $className = 'App\\Models\\' . basename($file, '.php');
    if (!class_exists($className)) {
        continue;
    }

    $reflection = new ReflectionClass($className);
    if (!$reflection->hasProperty('fillable')) {
        continue;
    }

    $fillable = $reflection->getDefaultProperties()['fillable'] ?? [];

    $table = Str::snake(Str::pluralStudly($reflection->getShortName()));

    $sql = "-- SQL for table: $schema.$table\n";
    $sql .= "CREATE TABLE IF NOT EXISTS `$schema`.`$table` (\n";
    $sql .= "  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,\n";
    $i = 0;
    foreach ($fillable as $field) {
        $type = 'VARCHAR(255)';

        if (Str::endsWith($field, '_id') || $field === 'user_id') {
            $type = 'BIGINT UNSIGNED';
        } elseif (Str::contains($field, 'date')) {
            $type = 'DATETIME';
        } elseif (Str::contains($field, 'content') || Str::contains($field, 'text')) {
            $type = 'TEXT';
        } elseif (Str::startsWith($field, 'is_')) {
            $type = 'TINYINT(1)';
        }

        $comma = ($i === count($fillable) - 1) ? "" : ",";
        $sql .= "  `$field` $type$comma\n";
        $i++;

    }

    //  $sql .= "  `created_at` TIMESTAMP NULL,\n";
    //  $sql .= "  `updated_at` TIMESTAMP NULL\n";
    $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";
    $sql .= "-----------------------------\n\n";

    file_put_contents($outputFile, $sql, FILE_APPEND);
}

echo "✅ SQL with schema `$schema` written to: $outputFile\n";
