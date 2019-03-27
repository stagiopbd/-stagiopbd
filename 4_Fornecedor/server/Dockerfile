FROM php:7.2-fpm

# Install some packages in to our container.
RUN apt-get -yqq update \
    && apt-get install -y --no-install-recommends \
        build-essential \
        apt-utils \
        libzip-dev \
        libpng-dev \
        libfreetype6-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        autoconf \
        g++ \
        make \
        openssl \
        libssl-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libsasl2-dev \
        libpcre3-dev \
        curl \
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
        ;

# RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
# RUN mv composer.phar /usr/local/bin/composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install some php extensions.
RUN pecl install mcrypt-1.0.1 \
    && docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
    mysqli \
    pdo_mysql \
    gd \
    && docker-php-ext-enable mcrypt \
    ;

# Set the default directory of the container.
WORKDIR /app

# Copy all the files from the current directory into
# the containers working directory (/app).
# COPY --chown=www-data:www-data . .
COPY . .
COPY ./config.development.sh /tmp 
# ENTRYPOINT ["/tmp/config.development.sh"]


# RUN composer install
# RUN composer dump-autoload

# # http://rizqi.id/deploy-script-for-laravel-projects
# # Step 2: Optimize Laravel. Pretty simple.
# RUN php artisan optimize
# RUN php artisan route:cache

# # Step 3: Clean up old caches
# RUN php artisan cache:clear

# # Step 4: Migrate your migrations. You know this drill.
# ENTRYPOINT ["php", "artisan", "migrate"]
