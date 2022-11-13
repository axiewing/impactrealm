<?php

namespace App\Controllers;


class Setting extends BaseController
{
    public function settings()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return view('settings');
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

            $user_c = auth()->user();
            $provider = model(setting('Auth.userProvider'));
            $user_c->setPassword($_POST["psw"]);
            $provider->save($user_c);
            
            $data = array(
                'msg_list' => ["Password Updated Successfuly"]
            );

            return view('settings', $data);
        }
    }
}
