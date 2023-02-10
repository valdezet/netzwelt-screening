# Use the official PHP image as the base image
FROM php:8.1-apache

# Copy the application files into the container
COPY . /var/www/html

# Set the working directory in the container
WORKDIR /var/www/html


# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
    intl \
    zip \
    && a2enmod rewrite

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --no-dev

# install node via nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
RUN export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install --lts \
    && nvm use --lts \
    && npm install --dev && npx vite build

ENV NODE_PATH $NVM_INSTALL_PATH/lib/node_modules
ENV PATH $NVM_INSTALL_PATH/bin:$PATH

# RUN [ -s "${HOME}/.nvm/nvm.sh" ] && \. "${HOME}/.nvm/nvm.sh"



# Expose port 80
EXPOSE 80


# Define the entry point for the container
CMD ["apache2-foreground"]
