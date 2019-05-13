<?php
require __DIR__ . '/src/bootstrap.php';

$di = new Xhgui_ServiceContainer();

$app = $di['app'];

require XHGUI_ROOT_DIR . '/src/routes.php';

$template_dir = realpath(XHGUI_ROOT_DIR . '/src/templates');

$templates = glob("$template_dir/**/*.twig");

foreach ($templates as $template) {
    $app->view()->getEnvironment()->loadTemplate(substr($template, strlen($template_dir) + 1));
}
