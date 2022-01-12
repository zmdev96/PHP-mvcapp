<?php
// Require Autoloder From Vendor
require_once('../vendor/autoload.php');


// Include .env File From The Main Path
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

/*
|--------------------------------------------------------------------------
| Custom Env Function
|--------------------------------------------------------------------------
| IF The Constants Not Isset In .env Will Return Defult Else Return Constants
| Accepted String, Integer, Boolean, Array with Separator (,)
*/
function env($env, $defult)
{
    if (getenv($env) != null) {
        return getenv($env);
    } else {
        return $defult;
    }
}
/*
|--------------------------------------------------------------------------
| Define Root Directory
|--------------------------------------------------------------------------
|  App Path, Dashboard Root Name, Dashboard Folder Name
*/
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('MAIN_APP', realpath(dirname(__FILE__)) . DS . '..' . DS);
define('DASHBOARD_ROOT_NAME', env('DASHBOARD_ROOT_NAME', 'dashboard'));
define('APP_DEBUG', env('APP_DEBUG', 'false'));


/*
|--------------------------------------------------------------------------
| Languages Configrations
|--------------------------------------------------------------------------
*/
defined('APP_LANGUAGES')     ? null : define('APP_LANGUAGES', explode(',', env('APP_LANGUAGES', 'en')));
defined('APP_DEFAULT_LANGUAGE')  ? null : define('APP_DEFAULT_LANGUAGE', env('APP_DEFAULT_LANGUAGE', 'en'));
/*

|--------------------------------------------------------------------------
| Define Resources Directory
|--------------------------------------------------------------------------
| [1] Front Resources
| [2] Dashboard Resources
*/
// [1]
define('VIEWS_PATH', MAIN_APP .  DS . 'resources' . DS . 'views' . DS);
define('VIEWS_COMPILES_PATH', MAIN_APP .  DS . 'storage' . DS . 'compiles' . DS);

define('LANGUAGES_PATH', MAIN_APP .  DS . 'resources' . DS . 'lang' . DS);
define('STORAGE_PATH', MAIN_APP .  DS . 'storage' . DS);


// [2]


/*
|--------------------------------------------------------------------------
| Database Credentials
|--------------------------------------------------------------------------
| The Const [DATABASE_CONN_DRIVER] descreib the MYSQL connection [PDO] OR [MYSQLI]
| The value [1] is for PDO and the value [2] is for MYSQLI
*/
defined('DATABASE_HOST_NAME')       ? null : define('DATABASE_HOST_NAME', env('DATABASE_HOST_NAME', 'localhost'));
defined('DATABASE_USER_NAME')       ? null : define('DATABASE_USER_NAME', env('DATABASE_USER_NAME', 'root'));
defined('DATABASE_PASSWORD')        ? null : define('DATABASE_PASSWORD', env('DATABASE_PASSWORD', ''));
defined('DATABASE_DB_NAME')         ? null : define('DATABASE_DB_NAME', env('DATABASE_DB_NAME', ''));
defined('DATABASE_PORT_NUMBER')     ? null : define('DATABASE_PORT_NUMBER', env('DATABASE_PORT_NUMBER', 3306));
defined('DATABASE_CONN_DRIVER')     ? null : define('DATABASE_CONN_DRIVER', env('DATABASE_CONN_DRIVER', 1));
defined('APP_SALT')                 ? null : define('APP_SALT', '$2a$07$yeNCSNwRpYopOhv0TrrReP$');

/*
|--------------------------------------------------------------------------
| Session configuration
|--------------------------------------------------------------------------
| Here the defination for the Session name,lift time and Storage Directory
|
*/
defined('SESSION_NAME')          ? null : define('SESSION_NAME', env('SESSION_NAME', '_MVCAPP_SESSION'));
defined('SESSION_LIFE_TIME')     ? null : define('SESSION_LIFE_TIME', 0);
defined('SESSION_SAVE_PATH')     ? null : define('SESSION_SAVE_PATH', MAIN_APP. 'sessions');
defined('SESSION_ADMIN')         ? null : define('SESSION_ADMIN', env('SESSION_ADMIN', 'authAdmin'));
defined('SESSION_WEB')           ? null : define('SESSION_WEB', env('SESSION_WEB', 'authWeb'));


/*
|--------------------------------------------------------------------------
| Define Js And CSS Files Directory
|--------------------------------------------------------------------------
| [1] is for Admin Panel
| [2] is for Front Siet
*/
// [1]
define('DASHBOARD_CSS', '/dist/dashboard/css/');
define('DASHBOARD_JS', '/dist/dashboard/js/');
define('DASHBOARD_VENDOR', '/dist/dashboard/vendor/');

// [2]
define('CSS', '/dist/css/');
define('JS', '/dist/js/');

/*
|--------------------------------------------------------------------------
| Custom Functions
|--------------------------------------------------------------------------
| [1] pre Function Output
| [2] dd  Function Output
*/
// [0] Return The Output as Pre style
function pre($data, $data1 = null, $data2 = null, $data3 = null)
{
    echo "<pre>";
    $result = var_dump($data) ;
    echo "</pre>";
    return $result;
}

// [1] Return The Output as array map style and kill the Script
if (!function_exists('dd')) {
    function dd()
    {
        array_map(function ($x) {
            echo "<pre>";
            var_dump($x);
            echo "</pre>";
        }, func_get_args());
        die;
    }
}


/*
|--------------------------------------------------------------------------
| SCRF TOKEN Configuration
|--------------------------------------------------------------------------
| This Function will cearte Session [scrf_token] if not isset
| After creation, the key will be encrypted and generated for the Views And Controller
*/


/*
|--------------------------------------------------------------------------
| URL Function
|--------------------------------------------------------------------------
|
| After creation, the key will be encrypted and generated for the Views And Controller
*/
