<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LeadModel;
use App\Models\PipelineModel;

class Leads extends BaseController
{
    protected $leadModel;
    protected $pipelineModel;

    public function __construct()
    {
        $this->leadModel = new LeadModel();
        $this->pipelineModel = new PipelineModel();
    }

    public function index()
    {
        $userId = session()->get('user')['id'];
        
        $data = [
            'title' => 'Meus Leads',
            'leads' => $this->leadModel->getUserLeads($userId)
        ];

        return view('user/leads/index', $data);
    }

    public function create()
    {
        $userId = session()->get('user')['id'];
        
        $data = [
            'title' => 'Criar Lead',
            'pipelines' => $this->pipelineModel->getUserPipelines($userId)
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[100]',
                'email'       => 'permit_empty|valid_email',
                'phone'       => 'permit_empty|min_length[8]|max_length[20]',
                'company'     => 'permit_empty|max_length[100]',
                'value'       => 'permit_empty|decimal',
                'pipeline_id' => 'required|numeric',
                'notes'       => 'permit_empty'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $pipelineId = $this->request->getPost('pipeline_id');
                
                // Buscar o primeiro estágio do pipeline
                $stages = $this->db->table('pipeline_stages')
                                  ->where('pipeline_id', $pipelineId)
                                  ->orderBy('order_position', 'ASC')
                                  ->get()
                                  ->getResultArray();
                
                if (empty($stages)) {
                    $data['error'] = 'O pipeline selecionado não possui estágios.';
                } else {
                    $leadData = [
                        'name'        => $this->request->getPost('name'),
                        'email'       => $this->request->getPost('email'),
                        'phone'       => $this->request->getPost('phone'),
                        'company'     => $this->request->getPost('company'),
                        'value'       => $this->request->getPost('value') ?: 0,
                        'pipeline_id' => $pipelineId,
                        'stage_id'    => $stages[0]['id'], // Primeiro estágio
                        'user_id'     => $userId,
                        'notes'       => $this->request->getPost('notes')
                    ];

                    if ($this->leadModel->insert($leadData)) {
                        return redirect()->to('/user/leads')->with('success', 'Lead criado com sucesso!');
                    } else {
                        $data['error'] = 'Erro ao criar lead.';
                    }
                }
            }
        }

        return view('user/leads/create', $data);
    }

    public function edit($id = null)
    {
        $userId = session()->get('user')['id'];
        $lead = $this->leadModel->where('id', $id)->where('user_id', $userId)->first();

        if (!$lead) {
            return redirect()->to('/user/leads')->with('error', 'Lead não encontrado.');
        }

        $data = [
            'title' => 'Editar Lead',
            'lead' => $lead,
            'pipelines' => $this->pipelineModel->getUserPipelines($userId),
            'stages' => $this->db->table('pipeline_stages')
                                ->where('pipeline_id', $lead['pipeline_id'])
                                ->orderBy('order_position', 'ASC')
                                ->get()
                                ->getResultArray()
        ];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'        => 'required|min_length[3]|max_length[100]',
                'email'       => 'permit_empty|valid_email',
                'phone'       => 'permit_empty|min_length[8]|max_length[20]',
                'company'     => 'permit_empty|max_length[100]',
                'value'       => 'permit_empty|decimal',
                'pipeline_id' => 'required|numeric',
                'stage_id'    => 'required|numeric',
                'notes'       => 'permit_empty'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $leadData = [
                    'name'        => $this->request->getPost('name'),
                    'email'       => $this->request->getPost('email'),
                    'phone'       => $this->request->getPost('phone'),
                    'company'     => $this->request->getPost('company'),
                    'value'       => $this->request->getPost('value') ?: 0,
                    'pipeline_id' => $this->request->getPost('pipeline_id'),
                    'stage_id'    => $this->request->getPost('stage_id'),
                    'notes'       => $this->request->getPost('notes')
                ];

                if ($this->leadModel->update($id, $leadData)) {
                    return redirect()->to('/user/leads')->with('success', 'Lead atualizado com sucesso!');
                } else {
                    $data['error'] = 'Erro ao atualizar lead.';
                }
            }
        }

        return view('user/leads/edit', $data);
    }

    public function delete($id = null)
    {
        $userId = session()->get('user')['id'];
        $lead = $this->leadModel->where('id', $id)->where('user_id', $userId)->first();

        if (!$lead) {
            return redirect()->to('/user/leads')->with('error', 'Lead não encontrado.');
        }

        if ($this->leadModel->delete($id)) {
            return redirect()->to('/user/leads')->with('success', 'Lead excluído com sucesso!');
        } else {
            return redirect()->to('/user/leads')->with('error', 'Erro ao excluir lead.');
        }
    }

    public function export()
    {
        $userId = session()->get('user')['id'];
        $leads = $this->leadModel->getUserLeads($userId);
        
        // Criar conteúdo CSV
        $csvContent = "ID,Nome,Email,Telefone,Empresa,Valor,Pipeline,Estágio,Data de Criação\n";
        
        foreach ($leads as $lead) {
            $csvContent .= sprintf(
                "%d,%s,%s,%s,%s,%.2f,%s,%s,%s\n",
                $lead['id'],
                $lead['name'],
                $lead['email'],
                $lead['phone'],
                $lead['company'],
                $lead['value'],
                $lead['pipeline_name'],
                $lead['stage_name'],
                $lead['created_at']
            );
        }
        
        // Definir headers para download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="leads_export_' . date('Y-m-d_H-i-s') . '.csv"');
        
        echo $csvContent;
        exit;
    }
}