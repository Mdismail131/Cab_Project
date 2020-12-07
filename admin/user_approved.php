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
$db = new DBconnection();
if (isset($_POST['filter_by_date'])) {
    $date_first = $_POST['date_first'];
    $date_Second = $_POST['date_to'];
    $to_do = "user_appr";
    $row_user = $user->filter_by_date($date_first, $date_Second, $to_do, $db->conn);
} elseif (isset($_POST['filter_by_name'])) {
    $name = $_POST['username'];
    $to_do = "user_appr";
    $row_user = $user->filter_by_name($name, $to_do, $db->conn);
} else {
    $row_user = $user->authen_user($db->conn);
}
if (isset($_POST['block_user'])) {
    $id = $_POST["hidden"];
    $user->block_user($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/user_approved.php');
}
if (isset($_POST["delete"])) {
    $to_do = "user";
    $id = $_POST["hidden"];
    $user->delete($id, $to_do, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/user_approved.php');
}
if (isset($_POST['submit'])) {
    $to_do = "user_appr";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data($sort_by, $to_do, $db->conn);
}
if (isset($_POST['submit_desc'])) {
    $to_do = "user_appr";
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_data_desc($sort_by, $to_do, $db->conn);
}
?>
<?php if (isset($row_user)) { ?>
<div class="header">
    <h1>Authenticated Users</h1>
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
</div>
<?php } ?>
<div class="fiter_sort">
    <?php if (isset($_POST['filter']) || isset($_POST['filter_by_fare']) || isset($_POST['filter_by_name']) || isset($_POST['filter_by_date'])) { ?>
        <button class="filter_btn_user">
            <a href="http://localhost/Cab_Project/admin/user_approved.php" style="text-decoration: none;">Clear</a>
        </button>
        <?php if (isset($_POST['filter_by_fare'])) {?>
            <div id="msg">
                <p>Filtered data by Name <?php echo $name ?></p>
            </div>
        <?php } elseif (isset($_POST['filter_by_date'])) {?>
            <div id="msg">
                <p>Filtered data by date  between <?php echo $date_first ?> to <?php echo $date_Second ?></p>
            </div>
        <?php } ?>
    <?php } else {?>
        <form method="post" class="filter_btn_user">
            <input type="submit" name="filter" value="Filter">
        </form>
    <?php } ?>
</div>
<div class="past_ride">
    <table class="past_ride_table" id="user">
        <thead>
            <tr>
                <th>User Id</th>
                <th>User_Name<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="user_name"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="user_name"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Name</th>
                <th>Date of signup<form method="post"><button type="submit" name="submit"><input type="hidden" name="sort" value="date_of_signup"><i class="fa fa-angle-up"></i></button><button type="submit" name="submit_desc"><input type="hidden" name="sort" value="date_of_signup"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Mobile Number</th>
                <th>Status</th>
                <!-- <th>Button</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($row_user as $key => $val) {
            ?>
            <tr>
                <td><?php echo $val['user_id']?></td>
                <td><?php echo $val['user_name']?></td>
                <td><?php echo $val['name']?></td>
                <td><?php echo $val['date_of_signup']?></td>
                <td><?php echo $val['mobile']?></td>
                <td><form method="post"><input type="hidden" name="hidden" value="<?php echo $val['user_id'];?>"><button type="submit" name="block_user"><i class='fa fa-ban'></i></button></form></td>
            <!-- <td><form method="post"><input type="hidden" name="hidden" value="<?php echo $val['user_id'];?>"><button type="submit" onClick="return confirm('Are you sure you wanna delete <?php /*echo $val['user_name'];*/?>');" name="delete"><i class='fa fa-trash'></i></button></form></td> -->
            </tr>
            <?php
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