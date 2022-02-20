FROM library/php:7.4.28-fpm-alpine3.14

LABEL maintainer="Vorobyev Andrey <73.vorobyev@gmail.com>"

ARG REDIS_VERSION=5.3.7

RUN set -eux \
    # dependencies
    && apk update \
    && apk add --no-cache --virtual .build-deps \
        autoconf \
        bash \
        cmake \
        clang \
        clang-libs \
        llvm10 \
        llvm10-libs \
        g++ \
        gcc \
        libc-dev \
        pcre-dev \
        make \
        git \
        pkgconf \
        re2c \
        freetype-dev \
        libpng-dev  \
        libjpeg-turbo-dev \
        oniguruma-dev \
        postgresql-dev \
        krb5 \
        krb5-dev \
        krb5-libs \
    && apk add --no-cache --virtual .persistent-deps \
        busybox-suid \
        coreutils \
        file \
        icu-dev \
        libxml2-dev \
        libressl-dev \
        freetype \
        libpng \
        libjpeg-turbo \
        zip \
        libzip \
        libzip-dev \
        postgresql-libs \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-freetype \
    && docker-php-ext-configure fileinfo --enable-fileinfo \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
        fileinfo \
        gd \
        intl \
        opcache \
        pdo \
        pdo_pgsql \
        zip \
    # redis
    && pecl install -o -f redis-${REDIS_VERSION} \
    && docker-php-ext-enable redis \
    # clear
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

COPY ./usr/local/etc /usr/local/etc

CMD ["/usr/local/sbin/php-fpm", "--fpm-config", "/usr/local/etc/php-fpm.conf", "-c", "/usr/local/etc/php/php.ini"]
