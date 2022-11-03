<?php

namespace App\Controllers;

class Home extends BaseController
{
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
    public function new_event()
    {
        return view('new_event');
    }
    public function settings()
    {
        return view('settings');
    }
}
