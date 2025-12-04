FROM php:8.3-apache

# Instalar extensões do PHP necessárias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite do Apache (caso necessário)
RUN a2enmod rewrite

# Configurar diretório de trabalho
WORKDIR /var/www/html
