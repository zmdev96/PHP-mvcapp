<?php
namespace Core;

class Request
{

    /**
     * Get All Server Variable
     * If Server has value return the server value
     * @return mixed
     */
    public function server($value = null)
    {
        if ($value == null) {
            return $_SERVER;
        } else {
            return $_SERVER[''.$value.''];
        }
    }

    /**
     * Get the Server Schema & Host
     * If baseUrl has value return current URL with Schema & Host
     * @return mixed
     */
    public function baseUrl($host = null)
    {
        if ($host !== null) {
            $server_scheme =  $_SERVER['REQUEST_SCHEME'];
            $server_host = $_SERVER['HTTP_HOST'];
            $server_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $base = $server_scheme. '://' . $server_host . $server_url;
            return $base;
        } else {
            $server_host = $_SERVER['HTTP_HOST'];
            $server_scheme =  $_SERVER['REQUEST_SCHEME'];
            $base = $server_scheme. '://' . $server_host;
            return $base;
        }
    }

    /**
     * Get the current URL
     * @return string
     */
    public function url()
    {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
          if (in_array($url[0], APP_LANGUAGES)) {
            $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 4);
            $urld = array_shift($url);
        }
        $url  = implode('/', $url);
        return $url;
    }

    /**
     * Get the current URL
     * @return string
     */
    public function prev($value = null)
    {
      $value = ($value !== null) ? $value : 0;
      $http_referers = array_reverse($_SESSION['http_referers']);
      $url = $http_referers[$value];
      return $url;
    }

    /**
     * Get the Server Method
     * If method has value return the Server Request Method
     * @return mixed
     */
    public function method($method = null)
    {
        if ($method == null) {
            return $_SERVER['REQUEST_METHOD'];
        } else {
            if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
                return true;
            }
        }
    }

    /**
     * Get the Requested Posts Method
     * @return string
     */
    public function post($method = null)
    {
        if ($method == null) {
            return $_POST;
        } else {
            if (isset($_POST[''.$method.''])) {
                return $_POST[''.$method.''];
            }
        }
    }
    /**
     * Get the Requested Get Method
     * @return string
     */
    public function get($method = null)
    {
        if ($method == null) {
            return $_GET;
        } else {
            return $_GET[''.$method.''];
        }
    }

    /**
     * Check if the Request is Ajax
     * @return bool
     */
    public function ajax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Response Json Function
     * accept two arguments the one is the responsed value and tow is the header
     * @return mixed
     */
    public function response($value, $header_type = null)
    {
        if ($header_type !== null) {
            header('HTTP/1.1 422 Unprocessable Entity');
        }
        echo json_encode($value);
    }

    /**
     * Redirect to the given URL
     * If isset session app_langauge will concatinate-
     * the seession app_langauge before the URL
     * Used the Super Global Variable $_SESSION
     * @return mixed
     */
    public function redirect($url)
    {
        if (isset($_SESSION['lang_changed'])) {
            $url = str_replace('.', DS, $url);
            $url = DS . $url;
            session_write_close();
            header('Location: ' .DS.$_SESSION['app_langauge'].$url);
            exit;
        } else {
            $url = str_replace('.', DS, $url);
            $url = DS . $url;
            session_write_close();
            header('Location: ' .$url);
            exit;
        }
    }

    /**
     * Redirect to the HTTP_REFERER URL
     * If isset Session current_url Redirct to it else to home
     * @return mixed
     */
    public function back()
    {
      if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
          session_write_close();
          header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
      } else {
          session_write_close();
          header('Location: ' . '/');
          exit;
      }
    }
}
