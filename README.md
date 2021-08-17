After clone to run
1. composer install
2. npm install
3. npm run prod
4. copy .env.example .env
5. php artisan key:generate

Create database, change .env database configs and run
1. php artisan migrate --seed
2. php artisan parse:news