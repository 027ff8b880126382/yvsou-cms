<?php
/**
 * © 2025 Hangzhou Domain Zones Technology Co., Ltd., Institute of Future Science and Technology G.K., Tokyo   All rights reserved.
 * Author: Lican Huang
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

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class GenerateMigrationsFromModels extends Command
{
    protected $signature = 'make:migrations-from-models';
    protected $description = 'Generate migration files based on models\' fillable fields';

    public function handle()
    {
        $modelsPath = app_path('Models');
        $files = (new Filesystem)->files($modelsPath);

        foreach ($files as $file) {
            $className = 'App\\Models\\' . $file->getFilenameWithoutExtension();
            if (!class_exists($className)) {
                require_once $file->getRealPath();
            }

            if (!class_exists($className)) {
                $this->warn("Class $className not found. Skipping.");
                continue;
            }

            $reflection = new \ReflectionClass($className);
            if (!$reflection->hasProperty('fillable')) {
                $this->warn("Model $className has no fillable property. Skipping.");
                continue;
            }

            $fillable = $reflection->getDefaultProperties()['fillable'] ?? [];

            $table = Str::snake(Str::pluralStudly($reflection->getShortName()));
            $migrationName = "create_{$table}_table";

            // Create migration stub content
            $migrationClassName = 'Create' . Str::studly($table) . 'Table';

            $stub = $this->buildMigrationContent($migrationClassName, $table, $fillable);

            // File name with timestamp
            $timestamp = date('Y_m_d_His');
            $fileName = database_path("migrations/{$timestamp}_{$migrationName}.php");

            file_put_contents($fileName, $stub);

            $this->info("Migration created: {$fileName}");
        }
    }

    protected function buildMigrationContent($className, $table, $fillable)
    {
        $fields = "";
        foreach ($fillable as $field) {
            // simple guess for field type
            $type = (Str::endsWith($field, '_id')) ? 'unsignedBigInteger' : 'string';
            $fields .= "            \$table->{$type}('{$field}');\n";
        }

        return <<<EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
{$fields}            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$table}');
    }
};

EOT;
    }
}
