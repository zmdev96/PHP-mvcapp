<?php
namespace Core;

use Core\Registry;

class Router
{
    private $_controller  = 'home';
    private $_action      = 'index';
    private $_arguments      = array();
    private $_routes;
    private $_lang;
    private $_url;
    private $_method;
    private $_post_data;

    public function __construct(Registry $registry, $routes, $application)
    {
        $this->_registry = $registry;
        $this->_routes = $routes;
        $this->_getRoutes();
    }

    public function __get($key)
    {
        return $this->_registry->$key;
    }

    /**
     * Parsenig the given  Request URL
     * $url_controller, $url_action, $url_arguments
     * @return string
     */
    private function _parseUrl()
    {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
        if (in_array($url[0], APP_LANGUAGES)) {
            $this->session->app_langauge = $url[0];
            $this->session->lang_changed = true;
            $this->_lang = true;
            $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 4);
            $urld = array_shift($url);
        }
        $url = implode('/', $url);
        $this->_url = $url;
        return $this;
    }

    /**
     * Genrate Pattern for the given Key
     * @return string
     */
    private function _pattern($key)
    {
        $pattern = '#^';
        $pattern .= str_replace(
            [':alphanum',':alpha',':int'],
            ['([a-zA-Z0-9-]+)','([a-zA-Z]+)','(\d+)'],
            $key
        );
        $pattern .= '$#';
        return $pattern;
    }

    /**
     * Match the given Request URL with $pattern
     * @return bool
     */
    private function _matching($pattern)
    {
        return (bool)  preg_match($pattern, $this->_parseUrl()->_url);
    }

    /**
     * Get Arguments from the current request URL
     * based on the given Pattern
     * @return array
     */
    private function _getArgument($pattern)
    {
        preg_match($pattern, $this->_parseUrl()->_url, $matches);
        array_shift($matches);
        return $matches;
    }

    private function _getRoutes()
    {
        foreach ($this->_routes['routes'] as $key => $value) {
            if ($key == '/') {
                $key = '';
            }
            // Gernrate Pattern For The Key
            $pattern = $this->_pattern($key);
            // Matching The Key With The Given Request Url
            if ($this->_matching($pattern) === true) {

                // Registry the last 5 http_referers in session
                if (isset($_SESSION['http_referers'])) {
                    if (count($_SESSION['http_referers']) == 5) {
                        if (end($_SESSION['http_referers']) !== $this->_parseUrl()->_url) {
                            array_shift($_SESSION['http_referers']);
                            array_push($_SESSION['http_referers'], $this->_parseUrl()->_url);
                        }
                    } else {
                        array_push($_SESSION['http_referers'], $this->_parseUrl()->_url);
                    }
                } else {
                    $_SESSION['http_referers'][] = $this->_parseUrl()->_url;
                }

                $matches = $this->_getArgument($pattern);
                $this->_arguments = $matches;
                $url_class  = $value[0];
                $this->_method = strtoupper($value[1]);
                $url_class = explode('@', $url_class);
                $this->_controller = $url_class[0];
                $this->_action = $url_class[1];
                //pre($url_class);
                break;
            } else {
                $this->_controller = 'Notfound';
                $this->_action =  'index';
            }
        }
    }

    /**
     * [1] Check if the request method is same the class method
     * [2] If the Request Method is Post check the CSRF_TOKEN
     * [3] If the Condations not true Redirect to back or the given URL
     * [4] Else Create new Class Name
     * @return mixed
     */
    public function dispatch()
    {
        if ($this->_method !==  null) {
            if ($this->request->method() !== $this->_method) {
                if (isset($this->session->current_url)) {
                    $url = $this->session->current_url;
                    $this->request->redirect($this->request->prev(1));
                }
            }
        }
        if ($this->request->method('post')) {
            $this->session->post_data = $_POST;
            if (null == $this->request->post('csrf_token')) {
                throw new \BadMethodCallException("[CSRF_TOKEN] Filed Notfound");
            } elseif ($this->request->post('csrf_token') !== CSRF_TOKEN) {
                $this->request->back();
            }
        }

        $controllerClass = str_replace('/', '\\', $this->_controller);
        $controllerName = 'App\Controllers\\' .$controllerClass. 'Controller';

        if (!class_exists($controllerName)) {
            $controllerName = 'App\Controllers\\NotfoundController';
            $this->_action = 'index';
        }
        if (!method_exists($controllerName, $this->_action)) {
            throw new \BadMethodCallException("Method [{$this->_action}] does not exist on [".$controllerName.'].');
        }
        $actionName= $this->_action;
        $router = new $controllerName($this->_registry);
        $router->setRegistry($this->_registry);
        $router->setController($this->_controller);
        $router->setAction($this->_action);
        $router->setParams($this->_arguments);
        $router->setLang($this->_lang);
        call_user_func_array([$router, $actionName], $this->_arguments);
    }
}
