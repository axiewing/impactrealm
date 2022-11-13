<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

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
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        if (auth()->loggedIn()) {
            $query = $this->select('*, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') as e_count')->where('event_date >=', $now)->orderBy('event.id', 'desc');
        } else {

            $query = $this->where('event_date >=', $now)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll(10, $offset);
    }

    public function get_all_events()
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        if (auth()->loggedIn()) {
            $query = $this->select('*, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') as e_count')->where('event_date >=', $now)->orderBy('event.id', 'desc');
        } else {

            $query = $this->where('event_date >=', $now)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll();
    }

    public function add_follower($id)
    {
        $this->set('follow_count', 'follow_count + 1', false)->where('id',$id)->update();
    }
    public function remove_follower($id)
    {
        $this->set('follow_count', 'follow_count - 1', false)->where('id',$id)->update();
    }

    public function get_attended_events()
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        $query = $this->select('*')
            ->where('event_date <=', $now)
            ->where('(SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') >= 1')
            ->orderBy('event.id', 'desc');
            
        //echo $query->countAllResults(); 
        return $query->findAll();
    }

    public function get_attending_events()
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        $query = $this->select('*, (SELECT COUNT(*) 
        FROM user_event WHERE event_id = id
        and user_id = ' . auth()->user()->id . ') as e_count')
            ->where('event_date >=', $now)
            ->where('(SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') >= 1')
            ->orderBy('event.id', 'desc');
            
        //echo $query->countAllResults(); 
        return $query->findAll();
    }
    public function my_events($offset = 0)
    {
        $query = $this->where('created_by', auth()->user()->id)->findAll(10, $offset);
        return $query;
    }
    public function del_event($id)
    {
        $query = $this->where('id', $id)->where('created_by', auth()->user()->id)->delete();
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
