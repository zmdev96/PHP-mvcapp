<?php
namespace App\Controllers\Auth;

use Core\Controller as Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        pre($this->request->url());
        $ref = explode('/', $this->request->url());
        if (in_array(DASHBOARD_ROOT_NAME, $ref)) {
            $this->session->kill();
            $this->request->redirect('app-admin/auth/login');
        } else {
            $this->session->kill();
            $this->request->redirect('auth/login');
        }
    }
}
