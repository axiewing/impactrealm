<?php

namespace Config;

use CodeIgniter\Shield\Models\UserModel;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/all-events', 'Event::all_events');
$routes->get('/event/(:num)', 'Event::show/$1');
$routes->get('/user/(:num)', 'Home::show_user/$1');
if (auth()->loggedIn()) {
    $super_admin_list = json_decode($_ENV["admin.list"]);
    if (in_array(auth()->user()->id, $super_admin_list)) {
        $routes->get('/add-admin/(:num)', 'Home::add_admin/$1');
        $routes->get('/remove-admin/(:num)', 'Home::rm_admin/$1');
    }
    $user = auth()->user();
    $user->touchIdentity($user->getEmailIdentity());
    $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => '0b786de358a7cdd8bd6d8ca8ed76b0ed-us21',
            'server' => 'us21'
        ]);
        $list_id = "1084a4ecb0";
        $umodel = new  UserModel();
        $uprofile = $umodel->get_profile();
        

        try {
            $response = $mailchimp->lists->addListMember($list_id, [
                "email_address" => $uprofile->secret,
                "status" => "subscribed",
                "merge_fields" => [
                "FNAME" => $uprofile->first_name,
                "LNAME" => $uprofile->last_name,
                ]
            ]);
        }catch (\Throwable $th) {
            //throw $th;
            //echo $th->getMessage();
        }

    $routes->get('/dashboard', 'Home::dashboard');
    //$routes->get('/test', 'Home::test');
    $routes->get('/notifications', 'Notification::all');
    $routes->get('/upcoming-events', 'Home::upcoming_events');
    $routes->get('/past-events', 'Home::past_events');
    $routes->get('/my-events', 'Event::my_events');
    $routes->post('/my-events', 'Event::my_events');
    $routes->get('/new-event', 'Event::new_event');
    $routes->get('/settings', 'Setting::settings');
    $routes->post('/settings', 'Setting::settings');
    $routes->post('/updateprofile', 'Setting::profile');
    $routes->post('/new-event', 'Event::new_event');
    $routes->get('/del-event/(:num)', 'Event::delete_event/$1');
    $routes->get('/edit-event/(:num)', 'Event::edit_event/$1');
    $routes->get('/a-del-event/(:num)', 'Event::a_delete_event/$1');
    $routes->get('/seen/(:num)', 'Event::seen_notif/$1');
    $routes->get('/attend-event/(:num)', 'Event::attend_event/$1');
    $routes->get('/unattend-event/(:num)', 'Event::unattend_event/$1');
} else {
    $routes->get('/dashboard', 'Home::index');
    $routes->get('/upcoming-events', 'Home::index');
    $routes->get('/past-events', 'Home::index');
    $routes->get('/my-events', 'Home::index');
    $routes->get('/new-event', function () {
        return view(setting('Auth.views')['login']);
    });
    $routes->get('/settings', 'Home::index');
}

service('auth')->routes($routes);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
