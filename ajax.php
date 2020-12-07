<?php
/**
 * Ajax File.
 * PHP version 5
 * 
 * @category Components
 * @package  PHP
 * @author   Md Ismail <mi0718839@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @version  SVN: $Id$
 * @link     https://yoursite.com
 */
session_start();
require "Location.php";
require "admin/DBconnection.php";

$user = new Location();
$db = new DBconnection();
$row = $user->show($db->conn);

$cur_loc = $_POST['currentloc'];
$destination = $_POST['droploc'];
$cab_type = $_POST['cabtype'];
$luggage = $_POST['luggage'];
$initial = null;
$final = null;
$fare = 0;

foreach ($row as $key => $val) {
    if ($val['name'] == $cur_loc) {
        $initial = $val['distance'];
    } elseif ($val['name'] == $destination) {
        $final = $val['distance'];
    }
}
if ($final > $initial) {
    $distance = ($final - $initial);
} else {
    $distance = ($initial - $final);
}

$_SESSION['distance'] = $distance;

if ($cab_type == 'CedMicro') {
    $fare = 50;
    if ($distance <= 10) {
        $fare = $fare + ($distance * 13.50);
    } elseif ($distance > 10 && $distance <=60) {
        $distance = $distance-10;
        $fare = $fare + (10 * 13.50) + ($distance * 12);
    } elseif ($distance > 60 && $distance <=160) {
        $distance = $distance-60;
        $fare = $fare + (10 * 13.50) + (50 * 12) + ($distance * 10.20);
    } elseif ($distance > 160) {
        $distance = $distance-160;
        $fare = $fare + (10 * 13.50) + (50 * 12) + (100 * 10.20) + ($distance * 8.50);
    }
}
if ($cab_type == 'CedMini') {
    $fare = 150;
    if ($distance <= 10) {
        $fare = $fare + ($distance * 14.50);
    } elseif ($distance > 10 && $distance <=60) {
        $distance = $distance-10;
        $fare = $fare + (10 * 14.50) + ($distance * 13);
    } elseif ($distance > 60 && $distance <=160) {
        $distance = $distance-60;
        $fare = $fare + (10 * 14.50) + (50 * 13) + ($distance * 11.20);
    } elseif ($distance > 160) {
        $distance = $distance-160;
        $fare = $fare + (10 * 14.50) + (50 * 13) + (100 * 11.20) + ($distance * 9.50);
    }
    if ($luggage != "") {
        if ($luggage>0 && $luggage <= 10) {
            $fare = $fare + 50;
        } elseif ($luggage > 10 && $luggage <= 20) {
            $fare = $fare + 100;
        } elseif ($luggage > 20) {
            $fare = $fare + 200;
        }
    }
}
if ($cab_type == 'CedRoyal') {
    $fare = 200;
    if ($distance <= 10) {
        $fare = $fare + ($distance * 15.50);
    } elseif ($distance > 10 && $distance <=60) {
        $distance = $distance-10;
        $fare = $fare + (10 * 15.50) + ($distance * 14);
    } elseif ($distance > 60 && $distance <=160) {
        $distance = $distance-60;
        $fare = $fare + (10 * 15.50) + (50 * 14) + ($distance * 12.20);
    } elseif ($distance > 160) {
        $distance = $distance-160;
        $fare = $fare + (10 * 15.50) + (50 * 14) + (100 * 12.20) + ($distance * 10.50);
    }
    if ($luggage != "") {
        if ($luggage>0 && $luggage <= 10) {
            $fare = $fare + 50;
        } elseif ($luggage > 10 && $luggage <= 20) {
            $fare = $fare + 100;
        } elseif ($luggage > 20) {
            $fare = $fare + 200;
        }
    }
}
if ($cab_type == 'CedSUV') {
    $fare = 250;
    if ($distance <= 10) {
        $fare = $fare + ($distance * 16.50);
    } elseif ($distance > 10 && $distance <=60) {
        $distance = $distance-10;
        $fare = $fare + (10 * 16.50) + ($distance * 15);
    } elseif ($distance > 60 && $distance <=160) {
        $distance = $distance-60;
        $fare = $fare + (10 * 16.50) + (50 * 15) + ($distance * 13.20);
    } elseif ($distance > 160) {
        $distance = $distance-160;
        $fare = $fare + (10 * 16.50) + (50 * 15) + (100 * 13.20) + ($distance * 11.50);
    }
    if ($luggage != "") {
        if ($luggage>0 && $luggage <= 10) {
            $fare = $fare + 100;
        } elseif ($luggage > 10 && $luggage <= 20) {
            $fare = $fare + 200;
        } elseif ($luggage > 20) {
            $fare = $fare + 400;
        }
    }
}
if (!isset($_SESSION['user'])) {
    $_SESSION['data'] = array(
        'from'      => $cur_loc,
        'to'        => $destination,
        'cab_type'  => $cab_type,
        'luggage'   => $luggage
    );
    $_SESSION['start'] = time();
}
$_SESSION['fare'] = $fare;
echo $fare;
?>