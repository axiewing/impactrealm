<?php

namespace App\Controllers;


class Notification extends BaseController
{

    public function all(){
        return view('all_notifications');
    }

}
