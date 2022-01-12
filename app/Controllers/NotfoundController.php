<?php
namespace App\Controllers;

use Core\Controller as Controller;

class NotfoundController extends Controller
{
    public function index()
    {
        $this->view('notfound.index', ['titlel' => 'Notfound']);
    }
}
