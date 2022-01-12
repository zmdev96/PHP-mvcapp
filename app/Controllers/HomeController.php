<?php
namespace App\Controllers;

use Core\Controller as Controller;
use App\Models\UserModel;

class HomeController extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->auth->checkIfAuthenticated('web');
    }

    public function index()
    {
        $this->language->load('home.index');

        $this->view('home.index', ['google' => 'this is google']);
    }
}
