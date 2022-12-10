<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;

class Setting extends BaseController
{
    public function profile()
    {
        $p_data = [
            'disc_id' => $_POST["discordid"],
            'twit_id' => $_POST["twitterid"],
            'first_name' => $_POST["fname"],
            'last_name' => $_POST["lname"],
        ];
        $u_model = new UserModel();
        $u_model->update(auth()->user()->id,$p_data);
        return redirect('settings');
    }
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
