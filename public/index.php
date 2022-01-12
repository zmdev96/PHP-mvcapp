<?php

use Core\Authentication;
use Core\Messenger;
use Core\Validations\Errors;
use Core\Registry;
use Core\Router;
use Core\Session;
use Core\Language;
use Core\Reporting;
use Core\Request ;

include '../config/config.php';
// Routes File
$routes = include '../routes/web.php';
// Run The Application Class [Error Handler]
$reporting = new Reporting();
// Start New Session
$session = new Session();
$session->start();
// Get the Language Session if Isset
if (!isset($session->app_langauge)) {
    $session->app_langauge = APP_DEFAULT_LANGUAGE;
}
$session->csrf_token = '';
defined('CSRF_TOKEN')   ? null : define('CSRF_TOKEN', hash_hmac(
    "sha256",
    "this is some string from 2019: str_replace.php",
    $_SESSION["csrf_token"]
).md5("you will be not found the key hahahaha"));

$request = new Request();
$language = new Language();
$messenger = Messenger::getInstance($session);
$erros = Errors::getInstance($session);
$authentication = Authentication::getInstance($session);
/**
* Registrition Classes
*/
$registry = Registry::getInstance();
$registry->request    = $request;
$registry->auth       = $authentication;
$registry->session    = $session;
$registry->language   = $language;
$registry->messenger  = $messenger;
$registry->errors     = $erros;


$router = new Router($registry, $routes, $reporting);
$router->dispatch();
