<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Shield\Models\UserModel;
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
            $query = $this->select('*, event.id as eid,username as author, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = event.id
            and user_id = ' . auth()->user()->id . ') as e_count')->join("users","created_by = users.id")->where('event_date >=', $now)->orderBy('event.id', 'desc');
        } else {

            $query = $this->select('*, event.id as eid,username as author')->join("users","created_by = users.id")->where('event_date >=', $now)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll(10, $offset);
    }

    public function get_alll_events()
    {
        $query = $this->select('*, event.id as eid ')->join('users', 'created_by= users.id')
            ->orderBy('event.id', 'desc');
        return $query->findAll();
    }



    public function get_all_events()
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        if (auth()->loggedIn()) {
            $query = $this->select('*,event.id as eid, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') as e_count')->where('event_date >=', $now)->orderBy('event.id', 'desc');
        } else {

            $query = $this->select('*,event.id as eid')->where('event_date >=', $now)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll();
    }
    public function get_user_events($uid)
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        if (auth()->loggedIn()) {
            $query = $this->select('*,event.id as eid, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') as e_count')->where('event_date >=', $now)->where('created_by =', $uid)->orderBy('event.id', 'desc');
        } else {

            $query = $this->select('*,event.id as eid')->where('event_date >=', $now)->where('created_by =', $uid)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll();
    }
    public function get_user_past_events($uid)
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        if (auth()->loggedIn()) {
            $query = $this->select('*,event.id as eid, (SELECT COUNT(*) 
            FROM user_event WHERE event_id = id
            and user_id = ' . auth()->user()->id . ') as e_count')->where('event_date <', $now)->where('created_by =', $uid)->orderBy('event.id', 'desc');
        } else {

            $query = $this->select('*,event.id as eid')->where('event_date <', $now)->where('created_by =', $uid)->orderBy('event.id', 'desc');
        }

        //echo $query->countAllResults(); 
        return $query->findAll();
    }

    public function add_follower($id)
    {
        $this->set('follow_count', 'follow_count + 1', false)->where('id', $id)->update();
    }
    public function remove_follower($id)
    {
        $this->set('follow_count', 'follow_count - 1', false)->where('id', $id)->update();
    }

    public function get_attended_events()
    {
        $now = date_format(new DateTime(), 'Y-m-d H:i:s');
        $query = $this->select('*,event.id as eid')
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
        $query = $this->select('*,event.id as eid, (SELECT COUNT(*) 
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
        $query = $this->select('*,event.id as eid')->where('created_by', auth()->user()->id)->findAll();
        return $query;
    }



    public function events_created_count()
    {
        $query = $this->select('COUNT(*) as create_count')->where('created_by', auth()->user()->id)->findAll();

        return $query;
    }
    public function get_event($id)
    {
        if (auth()->loggedIn()) {
            return $this->select('*,event.id as eid, (SELECT COUNT(*) 
        FROM user_event WHERE event_id = event.id
        and user_id = ' . auth()->user()->id . ') as e_count')->join('users', 'users.id  = event.created_by')->where('event.id', $id)->first();
        } else {
            return $this->select('*,event.id as eid')->join('users', 'users.id  = event.created_by')->where('event.id', $id)->first();
        }
    }
    public function get_event_start($id)
    {
        return $this->select('event_date')->where('id', $id)->first();
    }


    public function del_event($id)
    {
        $u_model = new UserModel();
        $admin_list = $u_model->get_admin_list();
        if (in_array(auth()->user()->id, $admin_list)) {
            return  $this->where('id', $id)->delete();
        }
        return  $this->where('id', $id)->where('created_by', auth()->user()->id)->delete();
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
        $notif_model = new Notification_model();

        $user_c = auth()->user();
        $u_name = $user_c->username;
        $u_id = $user_c->id;

        $u_model = new UserModel();

        $admin_list = $u_model->get_admin_list();
        $admin_list = array_diff($admin_list, array($u_id));

        $res = $this->insert($data, false);
        if ($res) {
            foreach ($admin_list as $admin) {
                $n_data = [
                    'user_id' => $admin,
                    'seen' => 0,
                    'content' => 'New Event is Created. Title: ' . $data["title"] .
                        '-- By the user: <a href="' . base_url() . '/user/' . $u_id . '">' . $u_name . '</a>',
                    'wide' => '',
                    'msg' => strlen($data["title"]) < 31 ? $data["title"] : substr($data["title"], 0, 28) . '...',
                    'des' => 'Event created by ' . $u_name,
                    'extra' => '',
                ];
                $notif_model->insert($n_data);
            }
            $n_data = [
                'user_id' => $u_id,
                'seen' => 0,
                'content' => 'Your Event is Created. Title: ' . $data["title"],
                'wide' => '',
                'msg' => strlen($data["title"]) < 31 ? $data["title"] : substr($data["title"], 0, 28) . '...',
                'des' => 'Event Sucessfuly created.',
                'extra' => '',
            ];
            $notif_model->insert($n_data);
        }
        return $res;
    }

    public function update_event($id, $data)
    {
        $this->update($id, $data);
    }
}
