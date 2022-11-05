<?php

use Predis\Command\Redis\APPEND;

include('top.php');
include('crousal.php');
?>


<?php
$events = array();
array_push($events,
(object)[
    'title'=>'Bitcoin event to dicuss the future',
    'time' => 'Fri, Dec 2, 9:30 PM',
    'cost' => 'Free',
    'address'=>'Harverd university, main block auditorium',
    'img_name' => 'imge1.jpg'
],
(object)[
    'title'=>'Bitcoin event to dicuss the future',
    'time' => 'Fri, Dec 2, 9:30 PM',
    'cost' => 'Free',
    'address'=>'Harverd university, main block auditorium',
    'img_name' => 'imge2.jpg'
],
(object)[
    'title'=>'Bitcoin event to dicuss the future',
    'time' => 'Fri, Dec 2, 9:30 PM',
    'cost' => 'Free',
    'address'=>'Harverd university, main block auditorium',
    'img_name' => 'imge3.jpg'
],
(object)[
    'title'=>'Bitcoin event to dicuss the future',
    'time' => 'Fri, Dec 2, 9:30 PM',
    'cost' => 'Free',
    'address'=>'Harverd university, main block auditorium',
    'img_name' => 'imge4.jpg'
],
(object)[
    'title'=>'Bitcoin event to dicuss the future',
    'time' => 'Fri, Dec 2, 9:30 PM',
    'cost' => 'Free',
    'address'=>'Harverd university, main block auditorium',
    'img_name' => 'imge5.jpg'
]
);
$events_obj = (object)[
    "title" => "Latest Events",
    "events" => $events
];

include ('event_listing.php');
array_pop($events);
$events_obj = (object)[
    "title" => "Popular Events",
    "events" => $events
];

include ('event_listing.php');

include('bottom.php');

?>