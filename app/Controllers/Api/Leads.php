<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LeadModel;
use CodeIgniter\API\ResponseTrait;

class Leads extends BaseController
{
    use ResponseTrait;
    
    protected $leadModel;

    public function __construct()
    {
        $this->leadModel = new LeadModel();
    }

    public function move($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Método não permitido', 405);
        }

        $userId = session()->get('user')['id'];
        $lead = $this->leadModel->where('id', $id)->where('user_id', $userId)->first();

        if (!$lead) {
            return $this->failNotFound('Lead não encontrado');
        }

        $json = $this->request->getJSON();
        
        if (!isset($json->stage_id)) {
            return $this->fail('Stage ID não fornecido');
        }

        // Verificar se o estágio pertence ao pipeline do lead
        $stage = $this->db->table('pipeline_stages')
                         ->where('id', $json->stage_id)
                         ->where('pipeline_id', $lead['pipeline_id'])
                         ->get()
                         ->getRowArray();

        if (!$stage) {
            return $this->fail('Estágio inválido para este pipeline');
        }

        if ($this->leadModel->moveToStage($id, $json->stage_id)) {
            return $this->respond(['success' => true, 'message' => 'Lead movido com sucesso']);
        } else {
            return $this->fail('Erro ao mover lead');
        }
    }
}