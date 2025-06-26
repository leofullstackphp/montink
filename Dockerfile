# Use uma imagem base do PHP com Apache
FROM php:8.2-apache

# Instale as extensões e ferramentas necessárias
RUN apt-get update && apt-get install -y \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Ativar mod_rewrite do Apache
RUN a2enmod rewrite

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure o diretório de trabalho
WORKDIR /var/www/html

# Copia todos os arquivos do projeto para dentro do container
COPY . /var/www/html

# Rodar o composer install
RUN composer install

# Exponha a porta 80
EXPOSE 80
