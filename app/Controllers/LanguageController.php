<?php
namespace App\Controllers;

use Core\Controller as Controller;

class LanguageController extends Controller
{
    public function index($lang)
    {
        if (isset($this->session->lang_changed)) {
            $this->session->app_langauge = $lang;
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = trim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), '/');
                $url = explode('/', $url);
                if (in_array($url[0], APP_LANGUAGES)) {
                    array_shift($url);
                    $url = implode('/', $url);
                    $this->request->redirect($url);
                }
            }
        } else {
            $this->session->lang_changed = true;
            $this->session->app_langauge = $lang;
            $this->request->redirect($this->request->prev(1));
        }
    }
}
