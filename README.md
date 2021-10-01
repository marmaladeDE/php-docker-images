# marmaladegmbh/php

## environment variables

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

