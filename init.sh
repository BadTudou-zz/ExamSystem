composer install
npm install
npm run dev

touch database/database.sqlite
php artisan queue:table
php artisan migrate
php artisan passport:install
php artisan db:seed
php artisan serve