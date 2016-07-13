FROM    php:5.6-apache

MAINTAINER Martin Schnabel <martin@webvariants.de>

ENV     WEB_ROOT            /app
ENV     XHPROF_VERSION      0.9.4

RUN     sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/apache2.conf \
     && sed -i "s|/var/www|\$\{WEB_ROOT\}|"      /etc/apache2/apache2.conf \
     && sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/sites-enabled/000-default.conf \
     && { \
            echo '<Directory ${WEB_ROOT}/>'; \
            echo '  Options Indexes FollowSymLinks'; \
            echo '  AllowOverride All'; \
            echo '  Require all granted'; \
            echo '</Directory>'; \
        } >> /etc/apache2/sites-enabled/000-default.conf \

     && apt-get update \
     && apt-get install -y \
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
            curl \
            graphicsmagick \
            msmtp \
            git \
            mercurial \

     && a2enmod rewrite headers expires \

     && curl https://pecl.php.net/get/xhprof-${XHPROF_VERSION}.tgz | tar -xpz -C /tmp xhprof-${XHPROF_VERSION}/extension \
     && mv /tmp/xhprof-${XHPROF_VERSION}/extension /usr/src/php/ext/xhprof \

     && echo "de_DE.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "it_IT.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "nl_NL.UTF-8 UTF-8" >> /etc/locale.gen \
     && locale-gen \
     && /usr/sbin/update-locale LANG=en_US.UTF-8 \

     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
     && docker-php-ext-configure xhprof --with-php-config=/usr/local/bin/php-config \

     && docker-php-ext-install \
            xhprof \
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
            mysql \
            pdo_mysql \

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

     && php -r "readfile('https://getcomposer.org/installer');" > /bin/composer-setup.php && php /bin/composer-setup.php --install-dir=/bin \

     && rm -r /usr/share/doc \
     && find /usr/src/php/ext -type d -name 'build' -print | xargs /bin/rm -rf \
     && find /usr/src/php/ext -type d -name 'autom4te.cache' -print | xargs /bin/rm -rf \
     && rm -r /var/lib/apt/lists/*

COPY    sendmail.ini               /usr/local/etc/php/conf.d/
COPY    php-sally.ini              /usr/local/etc/php/conf.d/
COPY    apache2-foreground-user    /usr/local/bin/

WORKDIR /app

CMD     ["apache2-foreground-user"]

# VOLUME /app/data
