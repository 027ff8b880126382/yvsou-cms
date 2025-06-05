#!/bin/bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled
php artisan optimize

rm -rf vendor
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create ZIP excluding dev files/folders
zip -r yvsou-cms.zip . -x \
  "build.sh" \
  "tailwind.config.js" \
  "postcss.config.js" \
  "vite.config.js" \
  "phpunit.xml" \
  ".github/*" \
  "node_modules/*" \
  ".git/*" \
  "tests/*" \
  ".editorconfig" \
  ".vscode/*" \
  "*.env" \
  "*.gitignore"
 
