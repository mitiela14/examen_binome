<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        echo view('template/header');
        echo view('login');
        echo view('template/footer');
    }

    public function auth()
    {
        $session = session();
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByCredentials($login, $password);

        if ($user) {
            $session->set('user', $user);
            return redirect()->to('/caisse');
        }

        return redirect()->back()->with('error', 'Identifiants invalides');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
