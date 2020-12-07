<?php
/**
 * Header File.
 * PHP version 5
 * 
 * @category Components
 * @package  PHP
 * @author   Md Ismail <mi0718839@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @version  SVN: $Id$
 * @link     https://yoursite.com
 */
require "sidebar.php";
require "../User.php";
require "../Ride.php";
require "../Location.php";
require "DBconnection.php";
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header('Location: http://localhost/Cab_Project/login.php');
}
$to_do = "";
$total = 0;
$user = new User();
$ride = new Ride();
$locations = new Location();
$db = new DBconnection();
$row_user = $user->authen_user($db->conn);
$pending_user = $user->user_pending($db->conn);
$all_users = $user->all_users($db->conn);
$all_rides = $user->join_table($db->conn);
$pending_ride = $ride->pending_ride($to_do, $db->conn);
$comp = $ride->completed_rides($to_do, $db->conn);
if ($comp != "") {
    foreach ($comp as $key => $val) {
        $total = $total + $val['total_fare'];
    }
}
$cancel_ride = $ride->cancel_ride($to_do, $db->conn);
$loc = $locations->show($db->conn);
?>
<body id="body">
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <div onclick="location.href='user_pending.php'">
            <div class="tile1">
            <i class="fa fa-user-plus">
            <?php if (!isset($pending_user)) {
                echo "  "."0";
            } else {
                echo "  ".sizeof($pending_user);
            } ?></i>
            <h3>SignUp Request</h3>
            </div>
        </div>
        <div onclick="location.href='user_approved.php'">
            <div class="tile2">
                <i class="fa fa-user-plus">
                <?php if (!isset($row_user)) {
                    echo "  "."0";
                } else {
                    echo "  ".sizeof($row_user);
                } ?></i>
                <h3>Authenticated Users</h3>
            </div> 
        </div>
        <div onclick="location.href='all_users.php'">
            <div class="tile3">
                <i class="fa fa-user-plus"><?php echo "  ".sizeof($all_users);?></i>
                <h3>All Users</h3>
            </div> 
        </div>
        <div onclick="location.href='total_pastride.php'">
            <div class="tile4">
            <i class="fa fa-taxi">
            <?php if ($all_rides == "") { 
                echo "  "."0"; 
            } else { 
                echo "  ".sizeof($all_rides);
            }?></i>
                <h3>All Rides</h3> </div>
        </div>
        <div onclick="location.href='pending_rides.php'">
            <div class="tile5">
            <i class="fa fa-taxi">
            <?php if ($pending_ride == "") { 
                echo "  "."0"; 
            } else { 
                echo "  ".sizeof($pending_ride);
            }?></i>
                <h3>Pending Ride</h3> </div>
        </div>
        <div onclick="location.href='completed_rides.php'">
            <div class="tile6">
            <i class="fa fa-taxi">
            <?php if ($comp == "") { 
                echo "  "."0"; 
            } else { 
                echo "  ".sizeof($comp);
            }?></i>
                <h3>Completed Ride</h3> </div>
        </div>
        <div onclick="location.href='cancelled_rides.php'">
            <div class="tile7">
            <i class="fa fa-taxi">
            <?php if ($cancel_ride == "") { 
                echo "  "."0"; 
            } else { 
                echo "  ".sizeof($cancel_ride);
            }?></i>
                <h3>Cancelled Rides</h3> </div>
        </div>
        <div onclick="location.href='loc_control.php'">
            <div class="tile8">
            <i class="fa fa-map-marker">
            <?php if ($loc == "") { 
                echo "  "."0"; 
            } else { 
                echo "  ".sizeof($loc);
            }?></i>
                <h3>Total Locations</h3> </div>
        </div>
        <div onclick="location.href='total_earning.php'">
            <div class="tile9">
            <i class="fa fa-rupee"><?php echo "   ".$total; ?></i>
                <h3>Total Earning</h3> </div>
        </div>
    </div>
<?php 
require "footer.php";
?>