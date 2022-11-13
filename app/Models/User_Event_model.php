<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Event_model;

class User_Event_model extends Model
{

    protected $table      = 'user_event';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id', 'event_id', 'extra'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function attend($e_id,$u_id)
    {
        $data = [
            'user_id' => $u_id,
            'event_id' => $e_id
        ];

        $e_model = new Event_model();
        $e_model->add_follower($e_id);

        return $this->insert($data, false);
    }
    public function unattend($e_id,$u_id){

        $e_model = new Event_model();
        $e_model->remove_follower($e_id);
        $query = $this->where('user_id', $u_id)->where('event_id', $e_id)->delete();
        return $query;
    }

    
}
