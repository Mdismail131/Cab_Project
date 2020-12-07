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
if (isset($_GET['action']) && ($_GET['action'] == 'logout')) {
    unset($_SESSION["user"]);
    unset($_SESSION["total_spent"]);
    header('Location: http://localhost/Cab_Project/login.php');
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="header">
        <nav>
            <a href="index.php"><img src="image/logo.jpg" alt=""></a>
            <?php
            if (isset($_SESSION['user'])) {
            ?>
            <ul id="menu">
                <li>
                    <a href="user_dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="index.php">Book Your Cab</a>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Previous Rides</button>
                        <div class="dropdown-content">
                            <a href="pending_rides.php">Pending Rides</a>
                            <a href="cancelled_rides.php">Cancelled Rides</a>
                            <a href="completed_rides.php">Completed Rides</a>
                            <a href="all_ride.php">All Rides</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Account</button>
                        <div class="dropdown-content">
                            <a href="user_info_edit.php">Update Info</a>
                            <a href="user_password.php">Update Password</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="http://localhost/Cab_Project/login.php?action=logout">Logout</a>
                </li>
            </ul>
        </nav>
        <div id="msg">
            Welcome <?php echo $_SESSION['user'];?>
        <?php
            } else {
        ?>
            <ul id="menu">
                <li>
                    <a href="index.php">Book Your Cab</a>
                </li>
                <li>
                    <a href="signup.php">Sign Up</a>
                </li>
                <li>
                    <a href="login.php">Sign In</a>
                </li>
            </ul>
        </nav>
        <div id="msg">
            Welcome Guest
        <?php
            }
        ?>
        </div>
    </div>

