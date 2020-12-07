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
require "admin/DBconnection.php";
require "Ride.php";
require 'User.php';
$title = "Cancelled Rides";
require "header.php";
if (!isset($_SESSION['user'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new User();
$ride = new Ride();
$db = new DBconnection();
if (isset($_POST['filter_by_date'])) {
    $date_first = $_POST['date_first'];
    $date_Second = $_POST['date_to'];
    $to_do = "ride_cancel";
    $row_user = $user->filter_by_date($date_first, $date_Second, $to_do, $db->conn);
} elseif (isset($_POST['filter_by_fare'])) {
    $fare = $_POST['fare']; 
    $to_do = "ride_cancel";
    $row_user = $user->filter_by_fare($fare, $to_do, $db->conn);
} else {
    $row_user = $ride->cancelled_rides($_SESSION['user_id'], $db->conn);
}
if (isset($_POST['submit'])) {
    $to_do = "ride_cancel";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data($sort_by, $to_do, $db->conn);
}
if (isset($_POST['submit_desc'])) {
    $to_do = "ride_cancel";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data_desc($sort_by, $to_do, $db->conn);
}
?>
<?php if (isset($row_user)) { ?>
 <div id="msg1">Cancelled Rides</div>
<?php if (isset($_POST['filter'])) {?>
    <div class="filter">
        <h3>Filter</h3>
        <form method="post">
            By Date: From<input type="date" name="date_first"> 
            To: <input type="date" name="date_to">
            <input type="submit" name="filter_by_date" value="Filter">
        </form><br>
        <form method="post">
            By Fare: <input type="text" name="fare">
            <input type="submit" name="filter_by_fare" value="Filter">
        </form><br>
    </div>
<?php } ?>
<div class="fiter_sort">
    <?php if (isset($_POST['filter']) || isset($_POST['filter_by_fare']) || isset($_POST['filter_by_date'])) { ?>
        <button id="filter_btn">
            <a href="http://localhost/Cab_Project/cancelled_rides.php">Clear</a>
        </button>
        <?php if (isset($_POST['filter_by_fare'])) {?>
            <div id="msg">
                <p>Filtered data by fare <?php echo $fare ?></p>
            </div>
        <?php } elseif (isset($_POST['filter_by_date'])) {?>
            <div id="msg">
                <p>Filtered data by date  between <?php echo $date_first ?> to <?php echo $date_Second ?></p>
            </div>
        <?php } ?>
    <?php } else {?>
    <form method="post" id="filter_btn">
        <input type="submit" name="filter" value="Filter">
    </form>
    <?php } ?>
</div>
<div id="previous_approved_ride" class="ride completed">
    <table>
        <thead>
            <tr>
                <th>Ride Id</th>
                <th>Ride Date<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="ride_date"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="ride_date"><i class="fa fa-angle-down"></i></button></form></th>
                <th>From</th>
                <th>To</th>
                <th>Total Distance</th>
                <th>Cab Type<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="cab_type"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="cab_type"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Luggage</th>
                <th>Total Fare<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="total_fare"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="total_fare"><i class="fa fa-angle-down"></i></button></form></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($row_user as $key => $val) {
            ?>
            <tr>
                <td><?php echo $val['ride_id']?></td>
                <td><?php echo $val['ride_date']?></td>
                <td><?php echo $val['from_loc']?></td>
                <td><?php echo $val['to_loc']?></td>
                <td><?php echo $val['total_distance']?></td>
                <td><?php echo $val['cab_type']?></td>
                <td><?php echo $val['luggage']?></td>
                <td><?php echo $val['total_fare']?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php } else {?>
<div>
    <h1>No Completed Ride to show</h1>
</div>
<?php } ?>
<?php
require "footer.php";
?>