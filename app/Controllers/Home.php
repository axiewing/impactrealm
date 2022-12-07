<?php

namespace App\Controllers;

use App\Models\Event_model;
use CodeIgniter\Shield\Models\UserModel;

class Home extends BaseController
{
    public function add_admin($id){
        $u_model = new UserModel();
        $u_model->make_admin($id);
        
        return redirect('dashboard');
    }
    public function rm_admin($id){
        $u_model = new UserModel();
        $u_model->revoke_admin($id);
        
        return redirect('dashboard');
    }

    public function show_user($id)
    {
        $data = array(
            'user_id' => $id,
        );

        return view('user_page', $data);
    }
    public function index()
    {
        return view('landing');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function upcoming_events()
    {
        return view('upcoming_events');
    }
    public function past_events()
    {
        return view('past_events');
    }
    public function my_events()
    {
        return view('my_events');
    }
    
    public function about()
    {
        return view('about');
    }
}
