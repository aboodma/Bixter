<?php

/*
 * Bixter front controller.
 * Defines constants and loads the framework kernel.
 */

declare(strict_types=1);

session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

require_once ROOT . DS . 'core' . DS . 'bootstrap.php';
