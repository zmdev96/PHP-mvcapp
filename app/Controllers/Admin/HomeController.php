<?php
namespace App\Controllers\Admin;

use Core\Controller as Controller;


class HomeController extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->auth->checkIfAuthenticated();
        //$this->auth->hasAccess($this);
    }

    public function index()
    {
        $this->language->load('admin.home.index');
        $this->view('admin.home.index');
    }


}
