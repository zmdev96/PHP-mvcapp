<?php
namespace App\Controllers;

use Core\Controller as Controller;
use Core\Helper;

class TestController extends Controller
{
    use Helper;

    public function index()
    {
      $value= [
        'error' => [
          'username' => 'requerd',
          'password' => 'error_password'
        ],
        'web' => [
          'google' => 'google . com ',
          'facebook'=> 'facebook . com'
        ]
      ];
      return json_encode($value);
    }
}
