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
session_start();
require "../Location.php";
require "DBconnection.php";
$title = "Locations Rides";
require "sidebar.php";
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new Location();
$db = new DBconnection();
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header('Location: http://localhost/Cab_Project/login.php');
}
if (isset($_POST['sort_btn'])) {
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_by($sort_by, $db->conn);
} elseif (isset($_POST['sort_btn_desc'])) {
    $sort_by = $_POST['sort'];
    $row_user = $user->sort_by_desc($sort_by, $db->conn);
} else {
    $row_user = $user->show($db->conn);
}
if (isset($_POST["block"])) {
    $id = $_POST['hidden'];
    $user->block_loc($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/loc_control.php');
}
if (isset($_POST["avail"])) {
    $id = $_POST['hidden'];
    $user->unblock_loc($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/loc_control.php');
}
if (isset($_POST["update"])) {
    $id = $_POST['hidden'];
    $name = $_POST['location'];
    $distance = $_POST['distance'];
    $user->update($id, $name, $distance, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/loc_control.php');
}
if (isset($_POST['submit'])) {
    $location = $_POST['location'];
    $distance = $_POST['distance'];
    $location = trim($location);
    $avail = $_POST['avail'];
    $user->add_loc($location, $distance, $avail, $db->conn);
}
if (isset($_POST["delete"])) {
    $id = $_POST['hidden'];
    $user->delete($id, $db->conn);
    header('Location: http://localhost/Cab_Project/admin/loc_control.php');
}
if (isset($_POST['filter_by_name'])) {
    $name = $_POST['name'];
    $row_user = $user->filter_by_name($name, $db->conn);
} elseif (isset($_POST['filter_by_distance'])) {
    $distance = $_POST['distance']; 
    $row_user = $user->filter_by_distance($distance, $db->conn);
}
?>
<div class="header">
    <h1>Location</h1>
</div>
<?php if (isset($_POST['Add'])) {?>
<div id="add_loc">
    <form method="post" class="form">
        <hr style="width:100%;">
        <h3>Add New-location</h3>
        <hr style="width:100%;">
        Location Name: <input type="text" id="location" name="location" required>
        Distance from charbagh : <input type="text" class="numbers" name="distance" required>
        Availability : <select name="avail">
            <option>0</option>
            <option>1</option>
        </select>
        <input type="submit" name="submit" value="Add">
    </form>
</div>
<?php } ?>
<?php if (!isset($_POST['Add'])) {?>
<form method="post">
    <input type="submit" id="add" name="Add" value="Add Location">
</form>
<?php } else {?>
    <button id="add">
        <a href="http://localhost/Cab_Project/admin/loc_control.php" style="text-decoration: none;margin-top: 10px">Close Form</a>
    </button>
<?php } ?>
<?php if (isset($row_user)) {?>
<?php if (isset($_POST['filter'])) {?>
    <div class="filter">
        <h3>Filter</h3>
        <form method="post">
            By Name: <input type="text" name="name">
            <input type="submit" name="filter_by_name" value="Filter">
        </form><br><br>
        <form method="post">
            By Distance: <input type="text" class="numbers" name="distance">
            <input type="submit" name="filter_by_distance" value="Filter">
        </form>
    </div>
<?php } ?>
<div class="fiter_sort">
    <?php if (isset($_POST['filter']) || isset($_POST['filter_by_name']) || isset($_POST['filter_by_distance'])) { ?>
        <button id="filter_btn" style="display: inline-block;margin-left: 27%;margin-top: 5%;">
            <a href="http://localhost/Cab_Project/admin/loc_control.php" style="text-decoration: none;">Clear</a>
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
        <form method="post" style="display: inline-block;margin-left: 27%;margin-top: 5%;">
            <input type="submit" name="filter" value="Filter">
        </form>
    <?php } ?>
</div>
<div id="locations">
    <table class="location_table">
        <thead>
            <tr>
                <th>Name<form method="post"><button type="submit" name="sort_btn"><input type="hidden" name="sort" value="name"><i class="fa fa-angle-up"></i></button><button type="submit" name="sort_btn_desc"><input type="hidden" name="sort" value="name"><i class="fa fa-angle-down"></i></button></form></th>
                <th>Distance</th>
                <th>Is_Available</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($row_user as $key => $val) {
            ?>
            <tr>
            <form method="post">
                <?php if (isset($_POST['edit']) && $_POST['hidden'] == $val['id']) { ?>
                    <td><input type="text" name="location" class="uname" value="<?php echo $val['name']?>"></td>
                <?php } else { ?>
                    <td><?php echo $val['name']?></td>
                <?php } ?>
                <?php if (isset($_POST['edit']) && $_POST['hidden'] == $val['id']) { ?>
                    <td><input type="text" name="distance" class="numbers" value="<?php echo $val['distance']?>"></td>
                <?php } else {?>
                    <td><?php echo $val['distance']."Km"?></td>
                <?php }?>
                <?php if ($val['is_available'] == 1) {?>
                    <td>Available</td>
                <?php } else {?>
                    <td>Un-available</td>
                <?php } ?>
                <?php if ($val['is_available'] == 1) { ?>
                    <td><input type="hidden" name="hidden" value="<?php echo $val['id'];?>"><button type="submit" class="danger" onClick="return confirm('Are you sure?')" name="block"><i class="fa fa-ban" style="color: red"></i></button></td>
                <?php } else {?>
                    <td><input type="hidden" name="hidden" value="<?php echo $val['id'];?>"><button type="submit" class="primary" onClick="return confirm('Are you sure?')" name="avail"><i class="fa fa-check" style="color:green"></i></button></td>
                <?php } ?>
                <?php if (isset($_POST['edit']) && $_POST['hidden'] == $val['id']) { ?>
                    <td><input type="hidden" name="hidden" value="<?php echo $val['id'];?>"><input type="submit" class="primary" onClick="return confirm('Are you sure?')" name="update" value="Update"></td>
                <?php } else {?>
                    <td><input type="hidden" name="hidden" value="<?php echo $val['id'];?>"><input type="submit" class="primary" onClick="return confirm('Are you sure?')" name="edit" value="Edit"></td>
                <?php } ?>
                <td><input type="hidden" name="hidden" value="<?php echo $val['id'];?>"><button type="submit" name="delete" onClick="return confirm('Are you sure?')" class="danger"><i class="fa fa-trash" style="color: red"></i></button></td>
            </tr>
            </form>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } else {?>
    <div>
        <h1 style="margin-left: 15%">No data to show Mr.<?php echo $_SESSION['admin']?></h1>
    </div>
<?php }?>
<?php 
require "footer.php";
?>