# Dockerfile para o backend PHP
# Usa a imagem oficial do PHP com Apache

FROM php:8.3-apache

# Instala as extensões do PHP necessárias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilita o mod_rewrite do Apache (para URLs amigáveis)
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html
