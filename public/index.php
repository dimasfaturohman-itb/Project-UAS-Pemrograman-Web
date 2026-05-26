<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once APP_ROOT . '/app/core/Security.php';
Security::startSession();
require_once APP_ROOT . '/app/core/helpers.php';
require_once APP_ROOT . '/app/core/Database.php';
require_once APP_ROOT . '/app/core/Model.php';
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Middleware.php';
require_once APP_ROOT . '/app/core/App.php';

spl_autoload_register(function (string $class): void {
    foreach (['/app/models/', '/app/controllers/', '/app/core/'] as $path) {
        $file = APP_ROOT . $path . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

new App();
