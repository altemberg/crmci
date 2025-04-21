<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gerenciar Usuários',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Criar Usuário'
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'      => 'required|min_length[3]|max_length[100]',
                'email'     => 'required|valid_email|is_unique[users.email]',
                'password'  => 'required|min_length[6]',
                'role'      => 'required|in_list[admin,user]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $userData = [
                    'name'     => $this->request->getPost('name'),
                    'email'    => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'role'     => $this->request->getPost('role'),
                    'active'   => 1
                ];

                if ($this->userModel->insert($userData)) {
                    return redirect()->to('/admin/users')->with('success', 'Usuário criado com sucesso!');
                } else {
                    $data['error'] = 'Erro ao criar usuário.';
                }
            }
        }

        return view('admin/users/create', $data);
    }

    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Usuário não encontrado.');
        }

        $data = [
            'title' => 'Editar Usuário',
            'user' => $user
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'      => 'required|min_length[3]|max_length[100]',
                'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
                'password'  => 'permit_empty|min_length[6]',
                'role'      => 'required|in_list[admin,user]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $userData = [
                    'name'  => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'role'  => $this->request->getPost('role')
                ];

                if ($this->request->getPost('password')) {
                    $userData['password'] = $this->request->getPost('password');
                }

                if ($this->userModel->update($id, $userData)) {
                    return redirect()->to('/admin/users')->with('success', 'Usuário atualizado com sucesso!');
                } else {
                    $data['error'] = 'Erro ao atualizar usuário.';
                }
            }
        }

        return view('admin/users/edit', $data);
    }

    public function delete($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Usuário não encontrado.');
        }

        // Não permite excluir o usuário admin principal
        if ($user['id'] == 1 && $user['role'] === 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Não é possível excluir o usuário administrador principal.');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('success', 'Usuário excluído com sucesso!');
        } else {
            return redirect()->to('/admin/users')->with('error', 'Erro ao excluir usuário.');
        }
    }
}