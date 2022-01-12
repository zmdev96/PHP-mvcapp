<?php

namespace Core;

class Reporting
{
    public function __construct()
    {
        $this->_set_reporting();
        $this->_unregister_globals();
    }

    /**
     * Set all Errors Reporting depending on the APP_DEBUG Constants
     */
    private function _set_reporting()
    {
        if (APP_DEBUG == 'true') {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            // Register Whoops Errors Handler
            // $whoops = new \Whoops\Run;
            // $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            // $whoops->register();
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
    }

    /**
     * Unregister globals Variables
     */
    private function _unregister_globals()
    {
        if (ini_get('register_globals')) {
            $globals_array = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
            foreach ($globals_array as $g) {
                foreach ($GLOBALS[$g] as $key => $value) {
                    if ($GLOBALS[$key] === $value) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
}
