<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class Notification_model extends Model
{

    protected $table      = 'notification';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id', 'seen', 'content',
        'wide', 'extra', 'msg', 'des'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    
    public function insert_event($data)
    {
        // $data = [
        //     'user_id' => '',
        //     'seen' => '',
        //     'content' => '',
        //     'wide' => '',
        //     'extra' => '',
        //     'msg' => '',
        //     'des' => '',
        // ];

        return $this->insert($data, false);
    }

    public function my_notifications($limit = 10)
    {
        $query = $this->where('user_id', auth()->user()->id)
        ->orderBy('id', 'desc')->where('seen', 0)->findAll($limit, 0);
        return $query;
    }

    public function seen($id){
        $upd =[
            'seen'=>1
        ];

        return $this->where('user_id', auth()->user()->id)->update($id, $upd);
    }


}
