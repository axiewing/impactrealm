<?php

namespace App\Controllers;

use App\Models\Event_model;
use App\Models\Notification_model;
use App\Models\User_Event_model;

class Event extends BaseController
{


    function str_rand($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function my_events()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return view('my_events');
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $eid = $_POST['eid'];

            $e_model = new Event_model();
            $event = $e_model->get_event($eid);
            $rand_name = $event["banner"];
            if (isset($_FILES['banner'])) {
                if ($_FILES['banner']['tmp_name']) {
                    if (!$_FILES['banner']['error']) {

                        $inputFile = $_FILES['banner']['name'];
                        $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
                        if ($extension == 'JPG' || $extension == 'PNG' || $extension == 'JPEG' || $extension == 'WEBP') {

                            try {
                                $rand_name = $this->str_rand(7) . "." . $extension;
                                $path_filename_ext =  FCPATH . "event_imgs" . DIRECTORY_SEPARATOR . $rand_name;
                                $z = move_uploaded_file($_FILES['banner']['tmp_name'], $path_filename_ext);
                            } catch (\Throwable $e) {
                                $error = array('msg_list' => ["Error while processsing request"]);

                                return view('my_events', $error);
                            }
                        } else {
                            $error = array('msg_list' => ["Upload only JPG or PNG file."]);

                            return view('my_events', $error);
                        }
                    } else {
                        $error = array('msg_list' => [$_FILES['banner']['error']]);

                        return view('my_events', $error);
                    }
                }
            }
            $e_data = [
                'title' => $_POST['title'],
                'event_date' => $_POST['starttime'],
                'banner' => $rand_name,
                'content' => $_POST['shortdescription'],
                'content_long' => $_POST['longdescription'],
                'address' => $_POST['address'],
            ];
            if($event["created_by"] == auth()->user()->id){
                $e_model->update($eid, $e_data);
                $data = array(
                    'msg_list' => ["Event Updated Successfuly"]
                );
            }else{
                $data = array(
                    'msg_list' => ["Don't try to do funny business."]
                );
            }

            return view('my_events', $data);
        }
    }
    public function show($id)
    {
        $e_model = new Event_model();
        $event = $e_model->get_event($id);
        $data = array(
            'event' => $event,
        );

        return view('single_event', $data);
    }
    public function edit_event($id)
    {
        $e_model = new Event_model();
        $ans = $e_model->get_event($id);
        $data = array(
            'event' => $ans,
        );

        return view('edit_event', $data);
    }
    public function delete_event($id)
    {
        $e_model = new Event_model();
        $ans = $e_model->del_event($id);
        if ($ans == 1) {
            $data = array(
                'msg_list' => ["Event Deleted Successfuly"]
            );
        } else {
            $data = array(
                'msg_list' => ["Error While Deleting"]
            );
        }
        return redirect()->to('/my-events');
    }
    public function a_delete_event($id)
    {
        $e_model = new Event_model();
        $ans = $e_model->del_event($id);
        if ($ans == 1) {
            $data = array(
                'msg_list' => ["Event Deleted Successfuly"]
            );
        } else {
            $data = array(
                'msg_list' => ["Error While Deleting"]
            );
        }
        return redirect('dashboard');
    }

    public function seen_notif($id)
    {
        $n_model = new Notification_model();
        $ans = $n_model->seen($id);

        return $ans;
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


    public function new_event()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return view('new_event');
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES['banner'])) {
                if ($_FILES['banner']['tmp_name']) {
                    if (!$_FILES['banner']['error']) {

                        $inputFile = $_FILES['banner']['name'];
                        $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
                        if ($extension == 'JPG' || $extension == 'PNG' || $extension == 'JPEG' || $extension == 'WEBP') {

                            try {
                                $rand_name = $this->str_rand(7) . "." . $extension;
                                $path_filename_ext =  FCPATH . "event_imgs" . DIRECTORY_SEPARATOR . $rand_name;
                                $z = move_uploaded_file($_FILES['banner']['tmp_name'], $path_filename_ext);
                                $e_model = new Event_model();
                                $e_data = [
                                    'title' => $_POST['title'],
                                    'event_date' => $_POST['starttime'],
                                    'banner' => $rand_name,
                                    'content' => $_POST['shortdescription'],
                                    'content_long' => $_POST['longdescription'],
                                    'address' => $_POST['address'],
                                    'cost' => 0,
                                    'created_by' => auth()->user()->id,
                                    'follow_count' => 0,
                                ];
                                $e_model->insert_event($e_data);
                                $data = array(
                                    'msg_list' => ["Event Created Successfuly"]
                                );

                                return view('new_event', $data);
                            } catch (\Throwable $e) {
                                $error = array('msg_list' => ["Error while processsing request"]);

                                return view('new_event', $error);
                            }
                        } else {
                            $error = array('msg_list' => ["Upload only JPG or PNG file."]);

                            return view('new_event', $error);
                        }
                    } else {
                        $error = array('msg_list' => [$_FILES['banner']['error']]);

                        return view('new_event', $error);
                    }
                }
            }

            return view('new_event');
        }
    }
}
