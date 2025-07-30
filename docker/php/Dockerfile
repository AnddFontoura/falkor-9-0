FROM php:8.1-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    vim \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório da aplicação
WORKDIR /var/www

# Copia o script de inicialização
COPY docker/php/start.sh /start.sh
RUN chmod +x /start.sh

# Define como ponto de entrada
ENTRYPOINT ["/start.sh"]

# Exponha a porta do Laravel
EXPOSE 8010
