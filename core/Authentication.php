<?php
namespace Core;

use App\Models\Admin\UsersModel;

class Authentication
{
    private static $_instance;
    private $_session;


    private function __construct($session)
    {
        $this->_session = $session;
    }

    private function __clone()
    {
    }

    /**
     * Get the session as Instance
     * @return mixed
     */
    public static function getInstance(Session $session)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    /**
     * Check if the user is Authorized
     * @return bool
     */
    public function check($provider = null)
    {
        if ($provider == null) {
            $provider = SESSION_ADMIN;
        } else {
            $provider = SESSION_WEB;
        }
        return isset($this->_session->$provider);
    }

    /**
     * Attachment given info in the table in database
     * Save the found record in Session (authUser)
     * @return mixed
     */
    public function attempt($info = array())
    {
        $app = require_once(MAIN_APP. 'config' . DS . 'app.php');

        if (count($info) !== 3) {
            throw new \Exception("Invalid attempt function array. Function accepted Array with just 3 argeuments");
        } else {
            $guards = $app['auth']['guards'][$info['guards']];

            $given_driver   = $guards['driver'];
            $given_provider = $guards['provider'];

            $provider = $app['auth']['providers'][$given_provider];

            return $provider::authenticate($info['username'], $info['password'], $this->_session);
        }
    }


    /**
     * Get the given key from session
     * accepted tow parameter the fiurst is
     * the wanted Key and the secound is the Session
     * @return mixed
     */
    public function get($key, $provider = null)
    {
        if ($provider == null) {
            $provider = SESSION_ADMIN;
        } else {
            $provider = SESSION_WEB;
        }
        return $this->_session->$provider->$key;
    }

    /**
     * Get All key from session
     * accepted one parameter [the session name]
     * @return array
     */
    public function getAll($provider = null)
    {
        if ($provider == null) {
            $provider = SESSION_ADMIN;
        } else {
            $provider = SESSION_WEB;
        }
        return $this->_session->$provider;
    }

    /**
     * Redirect If The User Authenticated
     * @return mixed
     */
    public function redirectIfAuthenticated($provider = null)
    {
        if ($provider == null) {
            $provider = SESSION_ADMIN;
        } else {
            $provider = SESSION_WEB;
        }
        if (isset($this->_session->$provider)) {
            if (isset($this->_session->http_referers)) {
                $http_referers = array_reverse($this->_session->http_referers);
                if (isset($http_referers[1])) {
                    $url = $http_referers[1];
                }
            }
            session_write_close();
            header('Location: /'. $url);
            exit;
        }
    }

    /**
     * [checkIfAuthenticated ]
     * @param  string $provider
     * @return bool
     */

    public function checkIfAuthenticated($provider = null)
    {
        if ($provider == null) {
            $provider = SESSION_ADMIN;
            $url = '/'.DASHBOARD_ROOT_NAME.'/auth/login';
        } else {
            $provider = SESSION_WEB;
            $url = '/auth/login';
        }

        if (!isset($this->_session->$provider)) {
            session_write_close();
            header('Location: '. $url);
            exit;
        }
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
            $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 4);
            $urld = array_shift($url);
        }
        $url = implode('/', $url);
        return $url;
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
        return (bool)  preg_match($pattern, $this->_parseUrl());
    }


    /**
     * Prepare The Privileges array and add the Admin Root Name to
     * Privileges array is from database
     * @return array
     */
    private function _privileges()
    {
       // user Privileges array will be stored on database
        $privileges = [
           'users',
           'users/index',
           'users/edit',
        ];

        $text = '';
        foreach ($privileges as $key) {
            $new_key = DASHBOARD_ROOT_NAME .'/'. $key. ',';
            $text .= $new_key;
            $add_key = explode('/', $new_key);
            if (end($add_key) == 'edit,') {
                $text .= str_replace('edit', 'update', $new_key);
            } elseif (end($add_key) == 'create,') {
                $text .= str_replace('create', 'store', $new_key);
            }
        }
        $prepared_privileges = explode(',', trim($text, ','));
        return $prepared_privileges;
    }

    /**
     * Ceck if the loged user has Access to the Class Method
     * Acceptd to Arguments Class Name, [excepted method]
     * @return mixed
     */
    public function hasAccess($class, $except = array())
    {
        $routes = include '../routes/web.php';
        // get the class dependend on the first atrgument ($class)
        $class = get_class($class);
        // get the class methods from the $class
        $class_methods = get_class_methods($class);
        // get the __get index from array ($class_methods) and assigned in variable
        $assigned = array_search('__get', $class_methods);
        // delete all array indexes after the current class methods
        array_splice($class_methods, $assigned);
        // remove the namespace from class name
        $routes_class = str_replace('App\Controllers\\', '', $class);
        $routes_class = str_replace('Controller', '', $routes_class);
        $routes_class = str_replace('\\', '/', $routes_class);
        // delete the except methods ($except argument) from the class method
        $class_methods = array_diff($class_methods, $except);
        foreach ($class_methods as $method) {
            $method_value = $routes_class . '@' . $method;
            foreach ($routes['routes'] as $key => $value) {
                if ($value[0] == $method_value) {
                    // Genrate Pattern for the key
                    $pattern = $this->_pattern($key);
                    // matching the Key with the given URL
                    if ($this->_matching($pattern) === true) {
                        // remove the Regex from key
                        $privi_link = explode(':', $key);
                        $privi_link = trim($privi_link[0], '/');
                        if (!in_array($privi_link, $this->_privileges())) {
                            dd('accessdenid');
                        }
                    }
                }
            }
        }
    }
}
