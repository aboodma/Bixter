<?php

declare(strict_types=1);

namespace Bixter\Core;

class Application
{
    public static ?Database $db = null;
    public static ?Session $session = null;

    public function __construct()
    {
        $this->_setReporting();
        self::$db = new Database();
        self::$session = new Session();
    }

    private function _setReporting(): void
    {
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
            ini_set('log_errors', '1');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
        }
    }
}
