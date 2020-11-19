<?php

namespace border_status;

/**
 * Load Composer if exists
 */
$composerAutoloader = DIR . '/vendor/autoload.php';

if (file_exists($composerAutoloader)) {
    include $composerAutoloader;
}

/**
 * Load Project classes with PSR-4 autoloader
 */
spl_autoload_register(function ($class) {
  $prefix = __NAMESPACE__ . '\\';
  $base_dir = DIR . 'app/';

  $len = strlen($prefix);

  if (strncmp($prefix, $class, $len) !== 0) {
    return;
  }

  $relative_class = substr($class, $len);
  $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

  if (file_exists($file)) {
    require $file;
  }
});

/**
 * Include and initialize main application
 */
App::init();
