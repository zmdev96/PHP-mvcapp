<?php
if (!function_exists('request')) {
    function request()
    {
        return  new Core\Request;
    }
}
