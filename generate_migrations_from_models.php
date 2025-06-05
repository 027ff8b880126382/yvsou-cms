<?php

use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$modelsPath = __DIR__ . '/app/Models';

foreach (glob("$modelsPath/*.php") as $file) {
    require_once $file;

    $className = 'App\\Models\\' . basename($file, '.php');
    if (!class_exists($className))
        continue;

    $reflection = new ReflectionClass($className);
    if (!$reflection->hasProperty('fillable'))
        continue;

    $fillable = $reflection->getDefaultProperties()['fillable'] ?? [];

    $table = Str::snake(Str::pluralStudly($reflection->getShortName()));

    echo "php artisan make:migration create_{$table}_table\n\n";

    echo "Schema::create('$table', function (Blueprint \$table) {\n";
    echo "    \$table->id();\n";

    foreach ($fillable as $field) {
        $type = str_contains($field, 'id') && $field !== 'id'
            ? 'unsignedBigInteger'
            : 'string';
        echo "    \$table->$type('$field');\n";
    }

    echo "    \$table->timestamps();\n";
    echo "});\n\n-----------------------\n\n";
}
