<?php

namespace Core;

use Core\Template\Template;
use Core\Validations\Validate;

abstract class Controller
{
    use Validate;

    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_lang;
    protected $_registry;

    public function __construct($registry)
    {
        $this->_registry = $registry;
        // TODO: Make better implementation to passed th  Registry Class
    }


    public function __get($key)
    {
        return $this->_registry->$key;
    }

    public function setController($controllerName)
    {
        $this->_controller = $controllerName;
    }
    public function setAction($actionName)
    {
        $this->_action = $actionName;
    }
    public function setParams($params)
    {
        $this->_params = $params;
    }
    public function setLang($lang)
    {
        $this->_lang = $lang;
    }

    public function setRegistry($registry)
    {
        $this->_registry = $registry;
    }

    protected function view($path, $data = null)
    {
        if ($data == null) {
            $data = [];
        }
        $compacted_data = array_merge($data, $this->language->getDictionary());
        $views = VIEWS_PATH;
        $cache = __DIR__ . '/cache';
        $blade = new Template($views, null, Template::MODE_AUTO, $this->_registry);
        echo $blade->run($path, $compacted_data);
    }
}
