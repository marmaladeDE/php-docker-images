<?php

if (extension_loaded('tideways_xhprof')) {
    define('XHGUI_TIDEWAYS_XHPROF', 1);
} else {
    if (!extension_loaded('xhprof')) {
        # error_log('xhgui - xhprof or tideways_xhprof must be loaded');  # be silent
        return;
    }
    define('XHGUI_TIDEWAYS_XHPROF', 0);
}

define('XHGUI_CONFIG_DIR', __DIR__ . '/config/');
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/perftools/xhgui-collector/src/Xhgui/Config.php';
Xhgui_Config::load(XHGUI_CONFIG_DIR . 'config.php');

if ((!extension_loaded('mongo') && !extension_loaded('mongodb')) && Xhgui_Config::read('save.handler') === 'mongodb') {
    error_log('xhgui - extension mongo not loaded');
    return;
}

if (!Xhgui_Config::shouldRun()) {
    return;
}

if (!isset($_SERVER['REQUEST_TIME_FLOAT'])) {
    $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
}

$full_profiling = Xhgui_Config::read('full_profiling');
if ($full_profiling) {
    $flags = Xhgui_Config::read('tideways.flags');
    if (is_callable($flags)) {
        $flags = $flags();
    }
    if (XHGUI_TIDEWAYS_XHPROF) {
        tideways_xhprof_enable($flags);
    } else {
        xhprof_enable($flags);
    }
    unset($flags);
}
else {
    define('PROFILE_START', microtime(true));
}
unset($full_profiling);

register_shutdown_function(
    function () {
        if (Xhgui_Config::read('full_profiling')) {
            $data['profile'] = XHGUI_TIDEWAYS_XHPROF ? tideways_xhprof_disable() : xhprof_disable();
            if (!XHGUI_TIDEWAYS_XHPROF) {
                $profile = [];
                foreach((array) $data['profile'] as $key => $value) {
                    $profile[strtr($key, ['.' => '_'])] = $value;
                }
                $data['profile'] = $profile;
            }
        } else {
            $data['profile'] = array(
                'main()' => array(
                    'wt' => (int) ((microtime(true) - (float) PROFILE_START) * 1000000),
                    'ct' => 1,
                    'pmu' => memory_get_peak_usage(true)
                )
            );
        }

        // ignore_user_abort(true) allows your PHP script to continue executing, even if the user has terminated their request.
        // Further Reading: http://blog.preinheimer.com/index.php?/archives/248-When-does-a-user-abort.html
        // flush() asks PHP to send any data remaining in the output buffers. This is normally done when the script completes, but
        // since we're delaying that a bit by dealing with the xhprof stuff, we'll do it now to avoid making the user wait.
        ignore_user_abort(true);
        if (function_exists('session_write_close')) {
            session_write_close();
        }
        flush();

        require '/xhgui/src/bootstrap.php';

        if (Xhgui_Config::read('fastcgi_finish_request') && function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        $uri = array_key_exists('REQUEST_URI', $_SERVER)
            ? $_SERVER['REQUEST_URI']
            : null;
        if (empty($uri) && isset($_SERVER['argv'])) {
            $cmd = basename($_SERVER['argv'][0]);
            $uri = $cmd . ' ' . implode(' ', array_slice($_SERVER['argv'], 1));
        }

        $replace_url = Xhgui_Config::read('profiler.replace_url');
        if (is_callable($replace_url)) {
            $uri = $replace_url($uri);
        }

        $time = array_key_exists('REQUEST_TIME', $_SERVER)
            ? $_SERVER['REQUEST_TIME']
            : time();

        // In some cases there is comma instead of dot
        $delimiter = (strpos($_SERVER['REQUEST_TIME_FLOAT'], ',') !== false) ? ',' : '.';
        $requestTimeFloat = explode($delimiter, $_SERVER['REQUEST_TIME_FLOAT']);
        if (!isset($requestTimeFloat[1])) {
            $requestTimeFloat[1] = 0;
        }

        $requestTs = array('sec' => $time, 'usec' => 0);
        $requestTsMicro = array('sec' => $requestTimeFloat[0], 'usec' => $requestTimeFloat[1]);

        $data['meta'] = array(
            'url' => $uri,
            'SERVER' => $_SERVER,
            'get' => $_GET,
            'env' => $_ENV,
            'simple_url' => Xhgui_Util::simpleUrl($uri),
            'request_ts' => $requestTs,
            'request_ts_micro' => $requestTsMicro,
            'request_date' => date('Y-m-d', $time),
        );

        try {
            $config = Xhgui_Config::all();
            $config += array('db.options' => array());
            $saver = Xhgui_Saver::factory($config);
            $saver->save($data);
        } catch (Exception $e) {
            error_log('xhgui - ' . $e->getMessage());
        }
    }
);