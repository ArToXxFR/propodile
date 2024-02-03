FROM php:8.3-apache AS php8.3-apache

# Change timezone
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    zip \
    awstats \
    cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable required Apache modules
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod ssl
RUN a2enmod cgi

# Install necessary PHP extensions
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        mbstring \
        pdo_mysql \
        xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the document root and environment
ENV WEB_DOCUMENT_ROOT /var/www/html/public

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .
RUN chown -R www-data:www-data /var/www/html

# Configure Apache
COPY docker/apache2/propodile.conf /etc/apache2/sites-available/000-default.conf
RUN cat docker/apache2/security.conf >> /etc/apache2/conf-available/security.conf




