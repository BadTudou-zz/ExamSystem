touch database/database.sqlite
php artisan migrate
php artisan passport:install
php artisan db:seed
php artisan serve