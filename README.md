how to install app for moment : 

git clone https://github.com/ArToXxFR/propodile.git
cd propodile/
composer install
npm install

Modify the .env file

php artisan key:generate
php artisan storage:link
php artisan migrate

to run :

php artisan serve
npm run dev