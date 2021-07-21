FROM php:7.3-apache

ENV ACCEPT_EULA=Y

RUN apt-get update && apt-get install -y gnupg2

# Microsoft SQL Server Prerequisites

RUN apt-get update \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get install -y --no-install-recommends \
    locales \
    apt-transport-https \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen \
    && apt-get update \
    && apt-get -y --no-install-recommends install \
    unixodbc-dev \
    msodbcsql17

RUN docker-php-ext-install mbstring pdo pdo_mysql \
    && pecl install sqlsrv pdo_sqlsrv xdebug \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv xdebug \
    && a2enmod rewrite

COPY resources/apache2.conf /etc/apache2/apache2.conf
# COPY resources/.htaccess /var/www/public/.htaccess

# COPY index.php /var/www/public