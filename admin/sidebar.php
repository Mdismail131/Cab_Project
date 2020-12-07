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
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:15%" id="nav">
    <img src="../image/logo.jpg" alt="Logo">
    <ul id='nav'>
		<li>
			<a href="admin_dashboard.php"  class="w3-bar-item w3-button">Admin Dashboard<i class="fa fa-user" style="margin-left: 5%;"></i></a>
		</li>
		<li>
			<div class="w3-dropdown-hover">
				<button class="w3-button">User<i class="fa fa-user" style="margin-left: 60%;"></i></button>
				<div class="w3-dropdown-content w3-bar-block">
					<a href="user_pending.php"  class="w3-bar-item w3-button">SignUP Requests</a>
					<a href="user_approved.php"  class="w3-bar-item w3-button">Allowed Users</a>
					<a href="all_users.php"  class="w3-bar-item w3-button">All User</a>
				</div>
			</div>
		</li>
		<li>
			<div class="w3-dropdown-hover">
				<button class="w3-button">Rides<i class="fa fa-taxi" style="margin-left: 53%;"></i></button>
				<div class="w3-dropdown-content w3-bar-block">
					<a href="pending_rides.php"  class="w3-bar-item w3-button">Pending Rides</a>
					<a href="completed_rides.php"  class="w3-bar-item w3-button">Completed Rides</a>
					<a href="cancelled_rides.php"  class="w3-bar-item w3-button">Cancelled Rides</a>
					<a href="total_pastride.php"  class="w3-bar-item w3-button">All Rides</a>
				</div>
			</div>
		</li>
		<li>
			<a href="loc_control.php"  class="w3-bar-item w3-button">Locations<i class="fa fa-map-marker" style="margin-left: 40%;"></i></a>
		</li>
		<li>
			<form method="post">
				<input type="submit" name="logout" value="Logout">
			</form>
		</li>
    </ul>
</div>
