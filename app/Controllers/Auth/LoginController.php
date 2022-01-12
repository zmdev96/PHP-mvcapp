<?php
namespace App\Controllers\Auth;

use Core\Controller as Controller;

class LoginController extends Controller
{
    public function login()
    {
        $ref = explode('/', $this->request->url());
        if (in_array(DASHBOARD_ROOT_NAME, $ref)) {
            $this->auth->redirectIfAuthenticated();
        } else {
            $this->auth->redirectIfAuthenticated('web');
        }
        $this->language->load('auth.login');
        $this->view('auth.login');
    }

    public function submit()
    {
        $url = explode('/', $this->request->prev(1));
        if ($url[0] == 'app-admin') {
            $auth = $this->auth->attempt([
            'guards' => 'admin', 'username' => $_POST['username'], 'password' => $_POST['password']
          ]);
            if ($auth) {
                $this->request->redirect('app-admin');
            } else {
                echo 'the account not found';
            }
        } else {
            $auth = $this->auth->attempt([
          'guards' => 'web', 'username' => $_POST['username'], 'password' => $_POST['password']
          ]);
            if ($auth) {
                $this->request->redirect('');
            } else {
                echo 'the account not found';
            }
        }
    }
}
