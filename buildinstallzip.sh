ver="0.9.0"
rm -rf vendor
cp  .env  .env.bak
cp env_install  .env     
cp ../config/yvsou_config.php ../config/yvsou_config.php.bak
cp yvsou_install_config.php ../config/yvsou_config.php
 
composer install --no-dev --optimize-autoloader
npm run build    # or skip if no frontend
php artisan config:cache
php artisan route:cache
php artisan view:cache
  
npm install
npm run build  
 
 
# Optional: remove compiled files manually
# rm -f bootstrap/cache/*.php

   
cd ..
zip -r yvsou-cms/yvsou-cms-installer-${ver}.zip   \
    yvsou-cms/app yvsou-cms/bootstrap yvsou-cms/config yvsou-cms/database yvsou-cms/public yvsou-cms/resources yvsou-cms/routes  yvsou-cms/vendor yvsou-cms/installer \
    yvsou-cms/composer.json \
    yvsou-cms/env.example yvsou-cms/yvsou_example_config.php yvsou-cms/install.sql yvsou-cms/server.php \
    --exclude=yvsou-cms/*.log --exclude=yvsou-cms/node_modules/* \
    --exclude=yvsou-cms/.git/* --exclude=yvsou-cms/config/yvsou_config.php \
    --exclude=yvsou-cms/bootstrap/cache/*.php   

cd yvsou-cms
cp  .env.bak  .env  
cp  config/yvsou_config.php.bak config/yvsou_config.php    
 

   
 