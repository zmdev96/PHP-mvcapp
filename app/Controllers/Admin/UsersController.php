<?php
namespace App\Controllers\Admin;

use Core\Controller as Controller;
use App\Models\Admin\AdminsModel;

class UsersController extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->auth->checkIfAuthenticated();
        $this->auth->hasAccess($this, ['show', 'create', 'store', 'add', 'add_store']);
    }

    public function index()
    {
        $this->language->load('admin.users.index');
        $this->view('admin.users.index');
    }

    public function create()
    {
        $this->language->load('admin.users.create');
        $this->view('admin.users.create');
    }

    public function store()
    {
        // Load The Language Files
        $this->language->load('admin.users.lables');
        $this->language->load('validations.validate');
        // Validations Roles
        $user_store = [
          'username'     => ['alpha',     'req|alphadash|between(10,24)|unique(app_users,Username,null)'],
          'firstname'    => ['alpha',     'req|alpha|between(3,24)'],
          'lastname'     => ['alpha',     'req|alpha|between(3,24)'],
          'image'        => ['file',      'req|image'],
        ];

        // If all Validation Roles are true continue the Script : Redirect back
        if ($this->isValid($user_store)) {
            //$this->request->response($_FILES['image']['name']);
            pre($_POST);
        } else {
            //$this->request->response($this->errors->getErrors(), true);
            $this->request->back();
            pre($_SESSION);
        }
    }

    public function edit($id)
    {
        $this->language->load('admin.users.edit');
        $user = AdminsModel::getByPK($id);
        if ($user) {
            $this->view('admin.users.edit', ['user' => $user]);
        } else {
            //$this->request->redirect('app-admin.users');
            echo 'users/edit';
        }
    }

    public function update()
    {
        // Load The Language Files
        $this->language->load('admin.users.lables');
        $this->language->load('validations.validate');
        // The Currnet ID
        $id = $this->request->post('id');
        // Validations Roles
        $user_update = [
        'username'     => ['string',   'req|alphanum|min(3)|unique(app_users,Username,'.$id.')'],
        'firstname'    => ['string',   'req|alpha|between(3,24)'],
        'lastname'     => ['string',   'req|alpha|between(5,24)'],


        ];
        // If all Validation Roles are true continue the Script : Redirect back
        if ($this->isValid($user_update)) {
            pre($_POST);
        } else {
            $this->request->redirect('app-admin.users');
        }
    }
}
