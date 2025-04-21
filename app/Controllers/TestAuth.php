<?php

namespace App\Controllers;

class TestAuth extends BaseController
{
    public function index()
    {
        return 'TestAuth controller is working!';
    }
    
    public function login()
    {
        // Tenta retornar uma view simples
        $data = [
            'title' => 'Login Test'
        ];
        
        // Verifica se a view existe
        if (file_exists(APPPATH . 'Views/auth/login.php')) {
            return view('auth/login', $data);
        } else {
            return 'View file not found: ' . APPPATH . 'Views/auth/login.php';
        }
    }
}