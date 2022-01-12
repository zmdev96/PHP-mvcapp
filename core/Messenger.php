<?php
namespace Core;

class Messenger
{
    const MESSAGE_SUCCESS       = 'success';
    const MESSAGE_ERROR         = 'danger';
    const MESSAGE_WARNING       = 'warning';
    const MESSAGE_INFO          = 'info';

    const MESSAGE_NOTIFY        = 'notify';
    const MESSAGE_ALERT         = 'alert';

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

    public function add($message, $type = self::MESSAGE_SUCCESS, $position = self::MESSAGE_ALERT)
    {
        if (!$this->messagesExists()) {
            $this->_session->messages = [];
        }
        $msgs = $this->_session->messages;
        $msgs[] = [$message, $type, $position ,$keyName ];
        $this->_session->messages = $msgs;
    }

    private function messagesExists()
    {
        return isset($this->_session->messages);
    }

    public function getMessages($all = null)
    {
        if ($this->messagesExists()) {
            $this->_messages = $this->_session->messages;
            unset($this->_session->messages);
            return $this->_messages;
        }
        return [];
    }
}
