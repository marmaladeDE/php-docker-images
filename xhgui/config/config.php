<?php

return array(
    'save.handler' => 'mongodb',
    'db.host' => getenv('XHGUI_MONGO_HOST') ?: 'mongo-xh', // 'mongodb://127.0.0.1:27017'
    'db.db' => getenv('XHGUI_MONGO_DATABASE') ?: 'xhprof',
    'db.options' => array(),
    'run.view.filter.names' => array(
        // 'Zend*',
        // 'Composer*',
    ),
    'profiler.enable' => function() {
        $probability = (float) getenv('XHGUI_PROBABILITY') ?: 0;
        if ($probability <= 0) {
            return false;
        }
        $url = is_array($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '';
        if (strpos($url, 'xhgui') !== false) {
            return false;
        }
        if ($probability >= 100) {
            return true;
        }
        return (rand(0, 10000) / 100) <= $probability;
    },

    'profiler.simple_url' => null,
    'profiler.replace_url' => null,
    'profiler.options' => array(),
    'date.format' => 'Y-m-d H:i:s',
    'detail.count' => 6,
    'page.limit' => 25,
    'cache' => getenv('XHGUI_CACHE') ?: (getenv('APP_DATA') . '/xhgui_cache' ),
    'tideways.flags' => function() {
        return 7;  // CPU + MEMORY  see https://github.com/tideways/php-xhprof-extension/blob/master/tracing.h
    }

);
