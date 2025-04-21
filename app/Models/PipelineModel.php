<?php

namespace App\Models;

use CodeIgniter\Model;

class PipelineModel extends Model
{
    protected $table            = 'pipelines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'user_id', 'created_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'        => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty|min_length[10]',
        'user_id'     => 'permit_empty|integer',
        'created_by'  => 'required|integer',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getPipelineWithStages($id)
    {
        return $this->db->table($this->table)
            ->select('pipelines.*, GROUP_CONCAT(pipeline_stages.name ORDER BY pipeline_stages.order_position) as stages')
            ->join('pipeline_stages', 'pipeline_stages.pipeline_id = pipelines.id', 'left')
            ->where('pipelines.id', $id)
            ->groupBy('pipelines.id')
            ->get()
            ->getRowArray();
    }

    public function getPipelinesWithStages()
    {
        return $this->db->table($this->table)
            ->select('pipelines.*, GROUP_CONCAT(pipeline_stages.name ORDER BY pipeline_stages.order_position) as stages')
            ->join('pipeline_stages', 'pipeline_stages.pipeline_id = pipelines.id', 'left')
            ->groupBy('pipelines.id')
            ->get()
            ->getResultArray();
    }

    public function getUserPipelines($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function assignToUser($pipelineId, $userId)
    {
        return $this->update($pipelineId, ['user_id' => $userId]);
    }
}