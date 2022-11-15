<?php

namespace App\Controllers;

use App\Models\Event_model;

class Home extends BaseController
{

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
