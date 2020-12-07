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
require "User.php";
require "Ride.php";
$title = "User Dashboard";
require "header.php";
if (!isset($_SESSION['user'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new User();
$ride = new Ride();
$db = new DBconnection();
$row_user = $user->distinct_user($_SESSION['user'], $db->conn);
$pending_rides = $ride->pending_ride($_SESSION['user_id'], $db->conn);
$completed_rides = $ride->completed_rides($_SESSION['user_id'], $db->conn);
$all_rides = $ride->all_ride($_SESSION['user_id'], $db->conn);
$total = 0;
if ($completed_rides != "") {
    foreach ($completed_rides as $key => $val) {
        $total = $val['total_fare'] + $total;
    }
}
?>
<div id="dashboard">
    <form method="post">
        <table id="dash_table">
            <tr>
                <td colspan="2">
                    <img id="image" src="image/images.jpeg" alt="">
                </td>
            </tr>
            <tr>
                <td>
                    Username:
                </td>
                <td>
                    <?php echo $row_user['user_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <?php echo $row_user['name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Mobile No.:
                </td>
                <td>
                    <?php echo $row_user['mobile']; ?>
                </td>
            </tr>
            <tr>
                <?php if (isset($_POST['edit_pass'])) {?>
                <td>
                    Password:
                </td>
                <td>
                    <input type="password" placeholder="Current Password" size="15" name="curr_password" required><br><br>
                    <input type="password" placeholder="New Password" size="15" name="new_password" required>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    Date of Signup:
                </td>
                <td>
                    <?php
                    $date = explode(' ', $row_user['date_of_signup']);
                    echo $date[0];
                    ?>
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="container">
    <div onclick="location.href='pending_rides.php'">
        <div class="tile1">
        <h1><?php 
        if ($pending_rides != "") {
            echo sizeof($pending_rides);
        } else {
            echo "0";
        }?></h1>
            <h3>Pending Rides</h3>
        </div>
    </div>
    <div onclick="location.href='completed_rides.php'">
        <div class="tile2">
            <h1><?php 
            if ($completed_rides != "") {
                echo sizeof($completed_rides);
            } else {
                echo "0";
            }?></h1>
                <h3>Completed Rides</h3>
        </div> 
    </div>
    <div onclick="location.href='all_ride.php'">
        <div class="tile3">
            <h1><?php 
            if ($all_rides != "") {
                echo sizeof($all_rides);
            } else {
                echo "0";
            }?></h1>
                <h3>All Rides</h3>
        </div>
    </div>
    <div onclick="location.href='javascript:void(0);'">
        <div class="tile4">
        <h1><?php 
        if ($total != "0") {
            echo "Rs.".$total;
        } else {
            echo "0";
        }?></h1>
            <h3>Total Fare</h3>
        </div> 
    </div>
</div>
<?php 
require "footer.php";
?>
