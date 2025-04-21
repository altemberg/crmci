<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->has('user')) {
            return redirect()->to('/login')->with('error', 'Você precisa fazer login para acessar esta página.');
        }
        
        $user = $session->get('user');
        if ($user['role'] !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não é necessário fazer nada após a resposta
    }
}