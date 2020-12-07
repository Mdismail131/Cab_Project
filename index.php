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
require "Ride.php";
require "Location.php";
require "admin/DBconnection.php";
$title = "Ced Cab";
require "header.php";

if (isset($_POST['book'])) {
    if (!isset($_SESSION['start'])) {
        $_SESSION['start'] = time();
    } elseif (time() - $_SESSION['start'] > 180) {
        unset($_SESSION['data']);
    }
    if (!isset($_SESSION['user'])) {
        unset($_SESSION);
        header('Location: http://localhost/Cab_Project/login.php');
    } else {
        $curr_loc = $_POST['curr_loc'];
        $destination = $_POST['destination'];
        $cab_type = $_POST['cab_type'];
        if ($cab_type == "CedMicro") {
            $luggage = 0;
        } else {
            $luggage = 0;
            if ($luggage == 0) {
                $luggage = 0;
            } else {
                $luggage = $_POST['luggage'];
            }
        }
        $distance = $_SESSION['distance'];
        $cust_id = $_SESSION['user_id'];
        $fare = $_SESSION['fare'];
        $date = Date("Y-m-d");
        $user = new Ride();
        $db = new DBconnection();
        $row = $user->book_ride($curr_loc, $destination, $cab_type, $luggage, $distance, $date, $cust_id, $fare, $db->conn);
    }
}
$user = new Location();
$db = new DBconnection();
$row = $user->show($db->conn);
?>
<div id="main">
    <div class="form">
        <form id="submit_form" method="post">
            <p id="head">CedCab</p>
            <hr>
            <h3 class="form_headings">Your everyday travel partner</h3>
            <p class="form_headings h1">AC Cabs for point to point travel</p>
            <span>PICKUP</span>
            <select id="FormControlSelect1" name="curr_loc">
                <option selected>Current Location</option>
                <?php foreach ($row as $key => $val) {
                    if ($val['is_available'] == '1') { ?>
                            <option><?php echo $val['name'];?></option>
                    <?php   }
                } ?>
            </select><br><br>
            <span>DROP</span>
            <select name="destination" id="FormControlSelect2">
                <option selected>Destination</option>
                <?php foreach ($row as $key => $val) {
                    if ($val['is_available'] == '1') { ?>
                            <option><?php echo $val['name'];?></option>
                    <?php   }
                } ?>
            </select><br><br>
            <span>CAB TYPE</span>
            <select name="cab_type" id="FormControlSelect3">
                <option selected>select cab type</option>
                <option>CedMicro</option>
                <option>CedMini</option>
                <option>CedRoyal</option>
                <option>CedSUV</option>
            </select><br><br>
            <span >LUGGAGE</span>
            <input type="text" id="luggage" class="numbers" name="luggage" placeholder="Enter Weight in kg"><br><br>
            <?php if (isset($_SESSION['user'])) { ?>
                <input type="button" name="calculate" id="calculate" value="Calculate Fare"><br><br>
                <input type="submit" name="book" id="book" value="Book cab" style="display: none;">
            <?php } else { ?>
                <input type="button" name="calculate" id="calculate" value="Calculate Fare"><br><br>
                <input type="submit" name="book" id="book" value="Book cab" style="display: none;">
            <?php } ?>
            <div id="res" style="display: none;">
                <p>Your Estimated Fare is Rs.<span id="result"></span></p>
            </div>
        </form>
    </div>
</div>
<?php
require "footer.php";
?>