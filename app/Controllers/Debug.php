<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        $data = [
            'base_url' => base_url(),
            'current_url' => current_url(),
            'app_path' => APPPATH,
            'controller_exists' => file_exists(APPPATH . 'Controllers/Auth.php'),
            'view_exists' => file_exists(APPPATH . 'Views/auth/login.php'),
            'model_exists' => file_exists(APPPATH . 'Models/UserModel.php'),
        ];
        
        return '<pre>' . print_r($data, true) . '</pre>';
    }
}