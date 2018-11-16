FROM    php:7.0-apache

MAINTAINER Martin Schnabel <martin@webvariants.de>

ENV     WEB_ROOT            /app

# https://github.com/SpiderLabs/ModSecurity/wiki/Reference-Manual-%28v2.x%29#Configuration_Directives
ENV     SecRuleEngine=DetectionOnly \
        SecRequestBodyAccess=On \
        SecRequestBodyLimit=13107200 \
        SecRequestBodyNoFilesLimit=131072 \
        SecRequestBodyInMemoryLimit=131072 \
        SecRequestBodyLimitAction=Reject \
        SecResponseBodyAccess=On \
        SecResponseBodyMimeType="text/plain text/html text/xml" \
        SecResponseBodyLimit=524288 \
        SecResponseBodyLimitAction=ProcessPartial \
        SecTmpDir=/tmp/ \
        SecDataDir=/tmp/ \
        SecAuditLogParts=ABDEFHIJZ \
        SecStatusEngine=On

RUN     sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/apache2.conf \
     && sed -i "s|/var/www|\$\{WEB_ROOT\}|"      /etc/apache2/apache2.conf \
     && sed -i "s|/var/www/html|\$\{WEB_ROOT\}|" /etc/apache2/sites-enabled/000-default.conf \
     && { \
            echo 'ServerName localhost'; \
            echo '<Directory ${WEB_ROOT}/>'; \
            echo '  Options FollowSymLinks'; \
            echo '  AllowOverride All'; \
            echo '  Require all granted'; \
            echo '</Directory>'; \
        } >> /etc/apache2/sites-enabled/000-default.conf \
     \
     && echo "force-unsafe-io" > /etc/dpkg/dpkg.cfg.d/02apt-speedup \
     && echo "Acquire::http {No-Cache=True;};" > /etc/apt/apt.conf.d/no-cache \
     && apt-get update && apt-get install -y gnupg2 \
     && curl -sL https://deb.nodesource.com/setup_4.x | bash - \
     \
     && apt-get install -y \
            libapache2-mod-security2 \
            nodejs \
            nano \
            locales \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libmcrypt4 \
            libmcrypt-dev \
            libcurl4-openssl-dev \
            libpng16-16 \
            libpng-dev \
            libxslt1.1 \
            libxslt1-dev \
            libxml2-dev \
            libicu57 \
            icu-devtools \
            libicu-dev \
            libtidy5 \
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
            unzip \
     \
     && export MAKEFLAGS="-j $(grep -c ^processor /proc/cpuinfo)" \
     && npm install --quiet -g npm@5 \
     && npm install --quiet -g grunt-cli bower \
     && npm cache clean --force \
     \
     && a2enmod rewrite headers expires security2 \
     && cp /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRuleEngine) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRequestBodyAccess) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRequestBodyLimit) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRequestBodyNoFilesLimit) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRequestBodyInMemoryLimit) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecRequestBodyLimitAction) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecResponseBodyAccess) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecResponseBodyMimeType) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecResponseBodyLimit) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecResponseBodyLimitAction) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecTmpDir) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecDataDir) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecAuditLogParts) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && sed -i -E "s/^(SecStatusEngine) .+$/\1 \$\{\1\}/g" /etc/modsecurity/modsecurity.conf \
     && cd /var/log/apache2 \
     && ln -s /dev/stderr modsec_audit.log \
     \
     && echo "de_DE.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "it_IT.UTF-8 UTF-8" >> /etc/locale.gen \
     && echo "nl_NL.UTF-8 UTF-8" >> /etc/locale.gen \
     && locale-gen \
     && /usr/sbin/update-locale LANG=en_US.UTF-8 \
     \
     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
     \
     && pecl install mongodb \
     && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini \
     \
     && pecl install apcu \
     && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \
     \
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
     \
     && apt-get remove -y \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libmcrypt-dev \
            libcurl4-openssl-dev \
            libpng-dev \
            libxslt1-dev \
            libxml2-dev \
            libicu-dev \
            libtidy-dev \
            zlib1g-dev \
            libxml2-dev \
            libssl-dev \
     \
     && php -r "readfile('https://getcomposer.org/installer');" > /bin/composer-setup.php && php /bin/composer-setup.php --install-dir=/bin \
     && ln -s /bin/composer.phar /bin/composer \
     \
     && rm -r /usr/share/doc \
     && rm -r /var/lib/apt/lists/*

COPY    apache2-foreground-user    /usr/local/bin/

WORKDIR /app

CMD     ["apache2-foreground-user"]

# VOLUME /app/data
