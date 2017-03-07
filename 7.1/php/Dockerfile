FROM    php:7.1-apache

MAINTAINER Martin Schnabel <martin@webvariants.de>

ENV     WEB_ROOT            /app

RUN     sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/apache2.conf \
     && sed -i "s|/var/www|\$\{WEB_ROOT\}|"      /etc/apache2/apache2.conf \
     && sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/sites-enabled/000-default.conf \
     && { \
            echo 'ServerName localhost'; \
            echo '<Directory ${WEB_ROOT}/>'; \
            echo '  Options Indexes FollowSymLinks'; \
            echo '  AllowOverride All'; \
            echo '  Require all granted'; \
            echo '</Directory>'; \
        } >> /etc/apache2/sites-enabled/000-default.conf \

     && curl -sL https://deb.nodesource.com/setup_6.x | bash - \

     && apt-get install -y \
            nodejs \
            nano \
            locales \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libmcrypt4 \
            libmcrypt-dev \
            libcurl4-openssl-dev \
            libpng12-dev \
            libxslt1.1 \
            libxslt1-dev \
            libxml2-dev \
            libicu52 \
            icu-devtools \
            libicu-dev \
            libtidy-0.99-0 \
            libtidy-dev \
            zlib1g-dev \
            libxml2-dev \
            curl \
            graphicsmagick \
            msmtp \
            git \
            mercurial \
            postgresql-client-common \
            postgresql-server-dev-all \
            libsqlite3-dev \
            libssl-dev \

     && npm install --quiet -g npm \
     && npm install --quiet -g grunt-cli bower \
     && npm cache clean \

     && a2enmod rewrite headers expires \

     && echo "de_DE.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "it_IT.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "nl_NL.UTF-8 UTF-8" >> /etc/locale.gen \
     && locale-gen \
     && /usr/sbin/update-locale LANG=en_US.UTF-8 \

     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \

     && pecl install mongodb \
     && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini \

     && pecl install apcu \
     && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \

     && docker-php-ext-install \
            opcache \
            tidy \
            iconv \
            curl \
            zip \
            mbstring \
            intl \
            xmlrpc \
            xsl \
            mcrypt \
            gd \
            pdo_mysql \
            pdo_pgsql \
            pdo_sqlite \
            mysqli \
            soap \

     && apt-get remove -y \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libmcrypt-dev \
            libcurl4-openssl-dev \
            libpng12-dev \
            libxslt1-dev \
            libxml2-dev \
            libicu-dev \
            libtidy-dev \
            zlib1g-dev \
            libxml2-dev \
            libssl-dev \

     && php -r "readfile('https://getcomposer.org/installer');" > /bin/composer-setup.php && php /bin/composer-setup.php --install-dir=/bin \
     && ln -s /bin/composer.phar /bin/composer \

     && rm -r /usr/share/doc \
     && rm -r /var/lib/apt/lists/*

COPY    apache2-foreground-user    /usr/local/bin/

WORKDIR /app

CMD     ["apache2-foreground-user"]

# VOLUME /app/data
