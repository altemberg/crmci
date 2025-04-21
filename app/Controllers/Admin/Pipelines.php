<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PipelineModel;
use App\Models\UserModel;

class Pipelines extends BaseController
{
    protected $pipelineModel;
    protected $userModel;

    public function __construct()
    {
        $this->pipelineModel = new PipelineModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gerenciar Pipelines',
            'pipelines' => $this->pipelineModel->getPipelinesWithStages()
        ];

        return view('admin/pipelines/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Criar Pipeline',
            'users' => $this->userModel->where('active', 1)->findAll()
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[100]',
                'description' => 'permit_empty|min_length[10]',
                'user_id'     => 'permit_empty|numeric'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $pipelineData = [
                    'name'        => $this->request->getPost('name'),
                    'description' => $this->request->getPost('description'),
                    'user_id'     => $this->request->getPost('user_id') ?: null,
                    'created_by'  => session()->get('user')['id']
                ];

                if ($this->pipelineModel->insert($pipelineData)) {
                    $pipelineId = $this->pipelineModel->getInsertID();
                    
                    // Criar estágios padrão
                    $this->createDefaultStages($pipelineId);
                    
                    return redirect()->to('/admin/pipelines')->with('success', 'Pipeline criado com sucesso!');
                } else {
                    $data['error'] = 'Erro ao criar pipeline.';
                }
            }
        }

        return view('admin/pipelines/create', $data);
    }

    public function edit($id = null)
    {
        $pipeline = $this->pipelineModel->find($id);

        if (!$pipeline) {
            return redirect()->to('/admin/pipelines')->with('error', 'Pipeline não encontrado.');
        }

        $data = [
            'title' => 'Editar Pipeline',
            'pipeline' => $pipeline,
            'users' => $this->userModel->where('active', 1)->findAll()
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[100]',
                'description' => 'permit_empty|min_length[10]',
                'user_id'     => 'permit_empty|numeric'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $pipelineData = [
                    'name'        => $this->request->getPost('name'),
                    'description' => $this->request->getPost('description'),
                    'user_id'     => $this->request->getPost('user_id') ?: null
                ];

                if ($this->pipelineModel->update($id, $pipelineData)) {
                    return redirect()->to('/admin/pipelines')->with('success', 'Pipeline atualizado com sucesso!');
                } else {
                    $data['error'] = 'Erro ao atualizar pipeline.';
                }
            }
        }

        return view('admin/pipelines/edit', $data);
    }

    public function delete($id = null)
    {
        $pipeline = $this->pipelineModel->find($id);

        if (!$pipeline) {
            return redirect()->to('/admin/pipelines')->with('error', 'Pipeline não encontrado.');
        }

        if ($this->pipelineModel->delete($id)) {
            return redirect()->to('/admin/pipelines')->with('success', 'Pipeline excluído com sucesso!');
        } else {
            return redirect()->to('/admin/pipelines')->with('error', 'Erro ao excluir pipeline.');
        }
    }

    public function assign($id = null)
    {
        $pipeline = $this->pipelineModel->find($id);

        if (!$pipeline) {
            return redirect()->to('/admin/pipelines')->with('error', 'Pipeline não encontrado.');
        }

        $data = [
            'title' => 'Atribuir Pipeline',
            'pipeline' => $pipeline,
            'users' => $this->userModel->where('active', 1)->findAll()
        ];

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');

            if ($this->pipelineModel->assignToUser($id, $userId)) {
                return redirect()->to('/admin/pipelines')->with('success', 'Pipeline atribuído com sucesso!');
            } else {
                $data['error'] = 'Erro ao atribuir pipeline.';
            }
        }

        return view('admin/pipelines/assign', $data);
    }

    private function createDefaultStages($pipelineId)
    {
        $defaultStages = [
            ['name' => 'Novo Lead', 'order_position' => 1],
            ['name' => 'Qualificação', 'order_position' => 2],
            ['name' => 'Proposta', 'order_position' => 3],
            ['name' => 'Negociação', 'order_position' => 4],
            ['name' => 'Fechado/Ganho', 'order_position' => 5],
            ['name' => 'Fechado/Perdido', 'order_position' => 6]
        ];

        $db = \Config\Database::connect();
        
        foreach ($defaultStages as $stage) {
            $stage['pipeline_id'] = $pipelineId;
            $db->table('pipeline_stages')->insert($stage);
        }
    }
}