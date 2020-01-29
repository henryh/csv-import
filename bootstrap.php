<?php

define('ROOT', dirname(realpath($_SERVER['argv'][0])));

spl_autoload_register(function($class) {
    $file = ROOT . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR
        .str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_file($file)) require_once($file);
});

?>