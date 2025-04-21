<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PipelineModel;
use App\Models\LeadModel;

class Pipelines extends BaseController
{
    protected $pipelineModel;
    protected $leadModel;

    public function __construct()
    {
        $this->pipelineModel = new PipelineModel();
        $this->leadModel = new LeadModel();
    }

    public function index()
    {
        $userId = session()->get('user')['id'];
        
        $data = [
            'title' => 'Meus Pipelines',
            'pipelines' => $this->pipelineModel->getPipelinesWithStages()->where('user_id', $userId)->findAll()
        ];

        return view('user/pipelines/index', $data);
    }

    public function view($id = null)
    {
        $userId = session()->get('user')['id'];
        $pipeline = $this->pipelineModel->where('id', $id)->where('user_id', $userId)->first();

        if (!$pipeline) {
            return redirect()->to('/user/pipelines')->with('error', 'Pipeline não encontrado.');
        }

        // Buscar estágios do pipeline
        $stages = $this->db->table('pipeline_stages')
                          ->where('pipeline_id', $id)
                          ->orderBy('order_position', 'ASC')
                          ->get()
                          ->getResultArray();

        // Buscar leads por estágio
        $leadsByStage = [];
        foreach ($stages as $stage) {
            $leads = $this->leadModel
                         ->where('pipeline_id', $id)
                         ->where('stage_id', $stage['id'])
                         ->where('user_id', $userId)
                         ->findAll();
            
            $leadsByStage[$stage['id']] = [
                'stage' => $stage,
                'leads' => $leads
            ];
        }

        $data = [
            'title' => 'Visualizar Pipeline: ' . $pipeline['name'],
            'pipeline' => $pipeline,
            'leadsByStage' => $leadsByStage
        ];

        return view('user/pipelines/view', $data);
    }
}