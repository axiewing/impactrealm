<?php

namespace App\Models;

use CodeIgniter\Model;


class Event_model extends Model
{

    protected $table      = 'event';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'title', 'event_date', 'banner',
        'content', 'content_long', 'address', 'cost', 'created_by', 'follow_count'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function get_ten_events($offset = 0)
    {
        $query = $this->findAll(10,$offset);
        return $query;
    }

    public function insert_event($data)
    {
        // $data = [
        //     'title' => '',
        //     'event_date' => '',
        //     'banner' => '',
        //     'content' => '',
        //     'content_long' => '',
        //     'address' => '',
        //     'cost' => '',
        //     'created_by' => '',
        //     'follow_count' => '',
        // ];

        return $this->insert($data, false);
    }

    public function update_event($id, $data)
    {
        $this->update($id, $data);
    }
}
