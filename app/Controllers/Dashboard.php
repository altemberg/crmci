<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PipelineModel;
use App\Models\LeadModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $pipelineModel;
    protected $leadModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pipelineModel = new PipelineModel();
        $this->leadModel = new LeadModel();
    }

    public function index()
    {
        $session = session();
        $currentUser = $session->get('user');
        
        $data = [
            'title' => 'Dashboard',
        ];

        if ($currentUser['role'] === 'admin') {
            $data['total_leads'] = $this->leadModel->countAllResults();
            $data['total_pipelines'] = $this->pipelineModel->countAllResults();
            $data['total_users'] = $this->userModel->countAllResults();
            $data['recent_leads'] = $this->leadModel->orderBy('created_at', 'DESC')
                                                   ->limit(5)
                                                   ->find();
        } else {
            $data['total_leads'] = $this->leadModel->where('user_id', $currentUser['id'])
                                                  ->countAllResults();
            $data['total_pipelines'] = $this->pipelineModel->where('user_id', $currentUser['id'])
                                                          ->countAllResults();
            $data['recent_leads'] = $this->leadModel->where('user_id', $currentUser['id'])
                                                   ->orderBy('created_at', 'DESC')
                                                   ->limit(5)
                                                   ->find();
        }

        return view('dashboard/index', $data);
    }
}