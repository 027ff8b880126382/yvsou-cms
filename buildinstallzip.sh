ver="0.9.0"
rm -rf vendor
composer install --no-dev --optimize-autoloader
npm run build    # or skip if no frontend
php artisan config:cache
php artisan route:cache
php artisan view:cache

npm install
npm run build  
cd ..
zip -r yvsou-cms/yvsou-cms-installer-${ver}.zip   \
    yvsou-cms/app yvsou-cms/bootstrap yvsou-cms/config yvsou-cms/database yvsou-cms/public yvsou-cms/resources yvsou-cms/routes  yvsou-cms/vendor yvsou-cms/installer \
    yvsou-cms/env.example yvsou-cms/yvsou_example_config.php yvsou-cms/yvsou_install.sql yvsou-cms/server.php \
    --exclude=yvsou-cms/*.log --exclude=yvsou-cms/node_modules/* --exclude=yvsou-cms/.git/* --exclude=yvsou-cms/config/yvsou_config.php
   

