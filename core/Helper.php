<?php
namespace Core;

trait Helper
{
    public function redirect($path)
    {
        if ($this->_lang == true) {
            session_write_close();
            header('Location: ' .  $path);
            exit;
        } elseif (isset($this->session->lang_changed)) {
            session_write_close();
            header('Location: ' .$this->session->app_langauge . DS .  $path);
            exit;
        } else {
            session_write_close();
            header('Location: ' .  $path);
            exit;
        }
    }

}
