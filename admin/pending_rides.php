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
require "DBconnection.php";
require "../User.php";
require "../Ride.php";
$title = "All Rides";
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new User();
$ride = new Ride();
$db = new DBconnection();
if (isset($_POST['filter_by_date'])) {
    $date_first = $_POST['date_first'];
    $date_Second = $_POST['date_to'];
    $to_do = "";
    $row_user = $user->filter_by_date($date_first, $date_Second, $to_do, $db->conn);
} elseif (isset($_POST['filter_by_name'])) {
    $name = $_POST['username']; 
    $to_do = "";
    $row_user = $user->filter_by_name($name, $to_do, $db->conn);
} elseif (isset($_POST['filter_by_fare'])) {
    $fare = $_POST['fare']; 
    $to_do = "";
    $row_user = $user->filter_by_fare($fare, $to_do, $db->conn);
} else {
    $row_user = $user->join_table($db->conn);
}
if (isset($_POST["cancel"])) {
    $id = $_POST["hidden"];
    $ride->cancel_ride($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/pending_rides.php');
}
if (isset($_POST["approved"])) {
    $id = $_POST['hidden'];
    $row_user = $ride->approved($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/pending_rides.php');
}
if (isset($_POST['submit'])) {
    $to_do = "";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data($sort_by, $to_do, $db->conn);
}
if (isset($_POST['submit_desc'])) {
    $to_do = "";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data_desc($sort_by, $to_do, $db->conn);
}
?>
<?php if (isset($row_user)) { ?>
<div class="header">
    <h1>Pending Rides</h1>
</div>
<?php if (isset($_POST['filter'])) {?>
    <div class="filter">
        <h3>Filter</h3>
        <form method="post">
            By Date: From<input type="date" name="date_first"> 
            To: <input type="date" name="date_to">
            <input type="submit" name="filter_by_date" value="Filter">
        </form><br>
        <form method="post">
            By Name: <input type="text" name="username">
            <input type="submit" name="filter_by_name" value="Filter">
        </form><br>
        <form method="post">
            By Fare: <input type="text" name="fare">
            <input type="submit" name="filter_by_fare" value="Filter">
        </form><br>
    </div>
<?php } ?>
<div class="fiter_sort">
    <?php if (isset($_POST['filter']) || isset($_POST['filter_by_fare']) || isset($_POST['filter_by_name']) || isset($_POST['filter_by_date'])) { ?>
        <button class="filter_btn_ride">
            <a href="http://localhost/Cab_Project/admin/pending_rides.php" style="text-decoration: none;">Clear</a>
        </button>
        <?php if (isset($_POST['filter_by_fare'])) {?>
            <div id="msg">
                <p>Filtered data by fare <?php echo $fare ?></p>
            </div>
        <?php } elseif (isset($_POST['filter_by_date'])) {?>
            <div id="msg">
                <p>Filtered data by date  between <?php echo $date_first ?> to <?php echo $date_Second ?></p>
            </div>
        <?php } elseif (isset($_POST['filter_by_name'])) {?>
            <div id="msg">
                <p>Filtered data by name <?php echo $name ?></p>
            </div>
        <?php } ?>
    <?php } else {?>
        <form method="post" class="filter_btn_ride">
            <input type="submit" name="filter" value="Filter">
        </form>
    <?php } ?>
</div>
<div class="past_ride">
    <table class="past_ride_table">
        <thead>
            <tr>
                <th>Ride Id</th>
                <th>Ride Date<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="ride_date"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="ride_date"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Customer Name<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="user_name"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="user_name"><i class="fa fa-angle-down"></i></button></form></th>
                <th>From</th>
                <th>To</th>
                <th>Total Distance</th>
                <th>Cab Type<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="cab_type"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="cab_type"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Luggage</th>
                <th>Total Fare<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="total_fare"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="total_fare"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Ride Status</th>
                <th>Button</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($row_user as $key => $val) {
                if ($val['status'] == 1 && $val['is_block'] == '1') {
            ?>
            <tr>
            <td><?php echo $val['ride_id']?></td>
            <td><?php echo $val['ride_date']?></td>
            <td><?php echo $val['user_name']?></td>
            <td><?php echo $val['from_loc']?></td>
            <td><?php echo $val['to_loc']?></td>
            <td><?php echo $val['total_distance']."Km"?></td>
            <td><?php echo $val['cab_type']?></td>
            <td><?php echo $val['luggage']."Kg"?></td>
            <td><?php echo "Rs".$val['total_fare']?></td>
            <td><?php echo "Pending";?></td>
            <td><form method="post"><input type="hidden" name="hidden" value="<?php echo $val['ride_id'];?>"><abbr title="Cancel"><button type="submit" name="cancel"><i class="fa fa-ban" style="color: red"></i></button></abbr><abbr title="Approve"><button type="submit" name="approved"><i class="fa fa-check" style="color: green"></i></button></abbr></form></td>
        </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php } else {?>
<div>
    <h1 class="empty">There is no record to show Mr.<?php echo $_SESSION['admin']?></h1>
</div>
<?php } ?>
<?php 
require "footer.php";
?>