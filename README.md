# webvariants/php

## tags

- [![](https://images.microbadger.com/badges/image/webvariants/php:7.3.svg)](https://microbadger.com/images/webvariants/php:7.3 "Get your own image badge on microbadger.com") ``7.3`` security until 6 Dec 2021
- [![](https://images.microbadger.com/badges/image/webvariants/php:7.3-fpm-alpine.svg)](https://microbadger.com/images/webvariants/php:7.3-fpm-alpine "Get your own image badge on microbadger.com") ``7.3-fpm-alpine`` security until 6 Dec 2021
- [![](https://images.microbadger.com/badges/image/webvariants/php:7.2.svg)](https://microbadger.com/images/webvariants/php:7.2 "Get your own image badge on microbadger.com") ``7.2`` security until 30 Nov 2020
- [![](https://images.microbadger.com/badges/image/webvariants/php:7.1.svg)](https://microbadger.com/images/webvariants/php:7.1 "Get your own image badge on microbadger.com") ``7.1`` security until 1 Dec 2019
- [![](https://images.microbadger.com/badges/image/webvariants/php:7.0.svg)](https://microbadger.com/images/webvariants/php:7.0 "Get your own image badge on microbadger.com") ``7.0`` end of life
- [![](https://images.microbadger.com/badges/image/webvariants/php:5.6.svg)](https://microbadger.com/images/webvariants/php:5.6 "Get your own image badge on microbadger.com") ``5.6`` end of life

## environment variables

- `PHP_IMAGE_VERSION` (empty) please set to `2` to be up to date and not in legacy mode!
- `WEB_ROOT` (`/app`)
- `APP_DATA` (`/app/data`)
- `WWW_USER` (www-data)
- `WWW_GROUP` (www-data)
- `PHP_EXTENSIONS`
- `PHP_ZEND_EXTENSIONS` (separete multiple extensions with space)
  - ex. `PHP_ZEND_EXTENSIONS=xdebug.so` (separete multiple extensions with space)
- `PHPINI_*`
  - ex. `PHPINI_XDEBUG__REMOTE_ENABLE=1` for `xdebug.remote_enable=1` (replace `.` with `__`)
- `PHP_MAIL_FROM` (`john.doe@example.com`)
- `PHP_MAIL_HOST` (`mail`)
- `PHP_SESSION_SAVE_PATH` (`$APP_DATA/session`)
- `PHP_UPLOAD_TMP_DIR` (`$APP_DATA/upload_tmp`)
- `PHP_UPLOAD_MAX_FILESIZE` (`64M`)
- `PHP_POST_MAX_SIZE` (`64M`)
- `PHP_PCRE_JIT` (`1`)
- `PHPINI_EXPOSE_PHP` (`off`)
- `ROBOTS_DISALLOW` (empty) creates `$WEB_ROOT/robots.txt` with `Disallow: $ROBOTS_DISALLOW`
- `STARTUP_CREATE_DIRS` (empty) `mkdir -p $STARTUP_CREATE_DIRS`
- `APP_DATA_DENY` (empty) creates `$APP_DATA/.htaccess`
- `STARTUP_CHOWN` chown
- `STARTUP_CHOWN_RECURSIVE` chown -R
- `STARTUP_REMOVE` rm -rf
- `SecRuleEngine` (DetectionOnly)
- `SecExclude` (empty)
  - ex. `SecExclude="SecRuleRemoveById 980130 949110"`
- `START_SCRIPT_DIR`
- `MINICRON_EXEC` (empty) run as cron container
- `MINICRON_CRONTAB` (empty)
  - ex. `MINICRON_CRONTAB=10 * * * * php cron.php`
- `MINICRON_FILE` (empty)
  - ex `MINICRON_FILE=/crontab`

## xhgui

xhqui is located at `/xhgui`

enable tracking with: `PHPINI_AUTO_PREPEND_FILE` set to `/xhgui/header.php` and following environment:

- `XHGUI_PROBABILITY` (`0`)
- `XHGUI_MONGO_HOST` (`mongo-xh`)
- `XHGUI_MONGO_DATABASE` (`xhprof`)
- `XHGUI_CACHE` (`$APP_DATA/xhgui_cache`)