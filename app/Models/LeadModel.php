<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table            = 'leads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'phone', 'company', 'value', 'pipeline_id', 'stage_id', 'user_id', 'notes'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'        => 'required|min_length[3]|max_length[100]',
        'email'       => 'permit_empty|valid_email',
        'phone'       => 'permit_empty|min_length[8]|max_length[20]',
        'company'     => 'permit_empty|max_length[100]',
        'value'       => 'permit_empty|decimal',
        'pipeline_id' => 'required|integer',
        'stage_id'    => 'required|integer',
        'user_id'     => 'required|integer',
        'notes'       => 'permit_empty',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getLeadWithDetails($id)
    {
        return $this->db->table($this->table)
            ->select('leads.*, pipelines.name as pipeline_name, pipeline_stages.name as stage_name, users.name as user_name')
            ->join('pipelines', 'pipelines.id = leads.pipeline_id')
            ->join('pipeline_stages', 'pipeline_stages.id = leads.stage_id')
            ->join('users', 'users.id = leads.user_id')
            ->where('leads.id', $id)
            ->get()
            ->getRowArray();
    }

    public function getUserLeads($userId)
    {
        return $this->db->table($this->table)
            ->select('leads.*, pipelines.name as pipeline_name, pipeline_stages.name as stage_name')
            ->join('pipelines', 'pipelines.id = leads.pipeline_id')
            ->join('pipeline_stages', 'pipeline_stages.id = leads.stage_id')
            ->where('leads.user_id', $userId)
            ->orderBy('leads.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getAllLeadsWithDetails()
    {
        return $this->db->table($this->table)
            ->select('leads.*, pipelines.name as pipeline_name, pipeline_stages.name as stage_name, users.name as user_name')
            ->join('pipelines', 'pipelines.id = leads.pipeline_id')
            ->join('pipeline_stages', 'pipeline_stages.id = leads.stage_id')
            ->join('users', 'users.id = leads.user_id')
            ->orderBy('leads.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function moveToStage($leadId, $stageId)
    {
        return $this->update($leadId, ['stage_id' => $stageId]);
    }

    public function getLeadsByPipeline($pipelineId)
    {
        return $this->db->table($this->table)
            ->select('leads.*, pipeline_stages.name as stage_name, pipeline_stages.order_position')
            ->join('pipeline_stages', 'pipeline_stages.id = leads.stage_id')
            ->where('leads.pipeline_id', $pipelineId)
            ->orderBy('pipeline_stages.order_position', 'ASC')
            ->get()
            ->getResultArray();
    }
}