FROM php:8.0.1-apache

WORKDIR /symfony

RUN sed -ri -e 's!/var/www/html!/symfony/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/symfony/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update \
    && apt-get install -y git unzip libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN curl -s https://composer.github.io/installer.sig > composer.sig \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r '$sig = trim(file_get_contents("./composer.sig")); if (hash_file("SHA384", "composer-setup.php") == $sig) { echo "Installer verified"; } else { echo "Installer corrupt"; unlink("composer-setup.php"); } echo PHP_EOL;' \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer