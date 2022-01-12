<?php
namespace Core\Validations;

use Core\Session;

class Errors
{
    private static $_instance;

    private $_session;

    private $_messages = [];


    private function __construct($session)
    {
        $this->_session = $session;
    }

    private function __clone()
    {
    }

    public static function getInstance(Session $session)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    public function add($keyName, $message)
    {
        if (!$this->errorsExists()) {
            $this->_session->errors = [];
        }
        $msgs = $this->_session->errors;
        $msgs [] = [$keyName => $message];
        $this->_session->errors = $msgs;
    }

    private function errorsExists()
    {
        return isset($this->_session->errors);
    }

    public function getErrors()
    {
        if ($this->errorsExists()) {
            $this->_messages = $this->_session->errors;
            $result = array();
            foreach ($this->_messages as $value) {
                $result = array_merge($result, $value);
            }
            unset($this->_session->errors);
            return $result;
        }
        return [];
    }


    public function hasError($input)
    {
        if ($this->errorsExists()) {
            $this->_messages = $this->_session->errors;
            foreach ($this->_messages as $value) {
                if (array_key_exists($input, $value)) {
                    return true;
                }
            }
        }
    }

    public function get($input)
    {
        // TODO: The Error unset will b hier not in footer
        if ($this->errorsExists()) {
            $this->_messages = $this->_session->errors;
            $result = array();
            foreach ($this->_messages as $value) {
                $result = array_merge($result, $value);
            }
            if (array_key_exists($input, $result)) {
                return $result[$input];
            }
        }
    }
}
