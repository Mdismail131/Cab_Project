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
// require "header.php";
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new User();
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
} elseif (isset($_POST['invoice'])) {
    $ride_id = $_POST['ride_id'];
    $row_user = $user->invoice($ride_id, $db->conn);
} else {
    $row_user = $user->join_table($db->conn);
}
if (isset($_POST['submit'])) {
    $sort_by = $_POST['sort'];
    $to_do = "";
    $row_user = $user->sort_data($sort_by, $to_do, $db->conn);
}
if (isset($_POST['submit_desc'])) {
    $to_do = "";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data_desc($sort_by, $to_do, $db->conn);
}
?>
<div class="header">
    <h1>Completed Rides</h1>
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
<?php if (!isset($_POST['invoice'])) {?>
<div class="fiter_sort">
    <?php if (isset($_POST['filter']) || isset($_POST['filter_by_fare']) || isset($_POST['filter_by_name']) || isset($_POST['filter_by_date'])) { ?>
        <button class="filter_btn_ride">
            <a href="http://localhost/Cab_Project/admin/completed_rides.php" style="text-decoration: none;">Clear</a>
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
<?php } ?>
<div class="past_ride">
    <?php if (isset($_POST['invoice'])) {?>
        <div id="print">
            <table class="past_ride_table" id="user_invoice">
                <caption style="background-color: #b3a38c;font-size: 20px;">Ride Invoice<button class="filter_btn_ride"><a href="http://localhost/Cab_Project/admin/completed_rides.php" style="text-decoration: none;">Clear</a></button>
                </caption>
                <?php foreach ($row_user as $key => $val) {?>
                <tr>
                    <th>Username</th>
                    <td><?php echo $val['user_name']?></td>
                </tr>
                <tr>
                    <th>Ride Id</th>
                    <td><?php echo $val['ride_id']?></td>
                </tr>
                <tr>
                    <th>From</th>
                    <td><?php echo $val['from_loc']?></td>
                </tr>
                <tr>
                    <th>To</th>
                    <td><?php echo $val['to_loc']?></td>
                </tr>
                <tr>
                    <th>Distance</th>
                    <td><?php echo $val['total_distance']."Km"?></td>
                </tr>
                <tr>
                    <th>Cab Type</th>
                    <td><?php echo $val['cab_type']?></td>
                </tr>
                <tr>
                    <th>Luggage</th>
                    <td><?php echo $val['luggage']."Kg"?></td>
                </tr>
                <tr>
                    <th>Total Fare</th>
                    <td><?php echo "Rs.".$val['total_fare']?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <button onclick="printDiv('print');" style="margin-left: 20%;margin-top: 15px">Print this page</button>
    <?php } else { ?>
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
                    if ($val['status'] == 2) {
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
                <td><?php echo "Rs.".$val['total_fare']?></td>
                <td><?php echo "Completed";?></td>
                <td>
                <form  method="post">
                    <input type="hidden" name="ride_id" value="<?php echo $val['ride_id']?>"><input type="submit" name="invoice" id="button" value="Invoice">
                </form>
                </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
</div>
    <?php }
    require "footer.php";
    ?>