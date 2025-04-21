<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        helper('form');
        return view('auth/login');
    }

    public function logout()
    {
        // Destroi a sessão e redireciona
        session()->destroy();
        return redirect()->to('/login');
    }
}