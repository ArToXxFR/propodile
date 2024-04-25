#!/bin/bash

NPM="npm"
ARTISAN="php artisan"

artisan_list=(
    "key:generate"
    "config:cache"
    "route:cache"
    "view:cache"
    "storage:link"
    "migrate --seed --force"
)

npm_list=(
    "install"
    "run prod"
)

run_artisan() {
    $ARTISAN $1
}

run_npm() {
    $NPM $1
}

# Install and configure the site for production
composer install --no-dev --ignore-platform-req=ext-http

# Run each php artisan command
echo "Building php artisan..."
for cmd in "${artisan_list[@]}"; do
    run_artisan "$cmd"
done

echo "Building npm..."
for cmd in "${npm_list[@]}"; do
    run_npm "$cmd"
done


# Remove tokens in apache2 config
echo "ServerTokens Prod" >> /etc/apache2/apache2.conf

touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html
echo "Installing prevention self signed certificate..."
openssl req -x509 -nodes -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt -subj "/C=FR/ST=State/L=City/O=Organization/CN=CommonName" 2>/dev/null
echo "Launching apache..."
apachectl -DFOREGROUND
