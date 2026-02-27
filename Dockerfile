FROM php:8.2-apache

# Instalamos mysqli y pdo por si luego lo necesitas
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos el módulo rewrite para Apache (opcional pero recomendado)
RUN a2enmod rewrite

# Copiamos el proyecto
COPY . /var/www/html/

# Ajustamos permisos
RUN chown -R www-data:www-data /var/www/html

# Esto evita el error de "headers already sent" al forzar el buffer de salida
RUN echo "output_buffering = 4096" > /usr/local/etc/php/conf.d/output-buffering.ini