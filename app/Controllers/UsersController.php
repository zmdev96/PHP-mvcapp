<?php
namespace App\Controllers;

use Core\Controller as Controller;
use App\Models\UserModel;

class UsersController extends Controller
{
    // Create Validation REG
    private $_createActionRoles =
     [
       'username'     => ['NaiceName',   'req|alphanum|between(6,24)'],
       'password'     => ['NaiceName',   'req|alphanum|between(6,60)'],

     ];

    public function index()
    {
        $this->language->load('validations.validate');
        $this->language->load('users.index');

        $this->view('users.index');
    }

    public function create()
    {
        $this->language->load('users.create');
        $this->view('users.create');
    }

    public function store()
    {
        echo $this->request->post('username');
    }
}
