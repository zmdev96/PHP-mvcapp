<?php
namespace Core;

class Language
{
    private $dictionary = [];

    public function load($path)
    {
        $defaultLanguage = APP_DEFAULT_LANGUAGE;
        if (isset($_SESSION['app_langauge'])) {
            $defaultLanguage =  $_SESSION['app_langauge'] ;
        }

        $path = explode('.', $path);
        if ($path[0] == 'admin') {
            $admin = array_shift($path);
            $admin =  $admin . DS;
        }

        $admin = isset($admin) ? $admin : '';
        $path = implode('/', $path);

        $languageFileToLoad = LANGUAGES_PATH . $admin . $defaultLanguage . DS . $path  . '.lang.php';

        if (file_exists($languageFileToLoad)) {
            require $languageFileToLoad;
            if (is_array($_) && !empty($_)) {
                foreach ($_ as $key => $value) {
                    $this->dictionary[$key] = $value;
                }
            }
        } else {
            trigger_error('Sorry the Language file ' . $path . ' doens\'t exists', E_USER_WARNING);
        }
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->dictionary)) {
            return $this->dictionary[$key];
        }
    }

    public function feedKey($key, $data)
    {
        if (array_key_exists($key, $this->dictionary)) {
            array_unshift($data, $this->dictionary[$key]);
            return call_user_func_array('sprintf', $data);
        }
    }

    public function getDictionary()
    {
        return $this->dictionary;
    }
}
