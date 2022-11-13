<?php

namespace App\Controllers;

use App\Models\Event_model;
use App\Models\User_Event_model;

class Event extends BaseController
{
    public function delete_event($id)
    {
        $e_model = new Event_model();
        $ans = $e_model->del_event($id);
        if ($ans == 1) {
            $data = array(
                'msg_list' => ["Event Deleted Successfuly"]
            );
        }else{
            $data = array(
                'msg_list' => ["Error While Deleting"]
            );
        }
        return redirect()->to('/my-events');
    }

    public function attend_event($id)
    {
        $ue_model = new User_Event_model();
        return $ue_model->attend($id, auth()->user()->id);
    }
    public function unattend_event($id)
    {
        $ue_model = new User_Event_model();
        return $ue_model->unattend($id, auth()->user()->id);
    }

    public function all_events()
    {
        return view('all_events');
    }
}
