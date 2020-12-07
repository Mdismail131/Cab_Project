<?php
/**
 * Global settings/Elements.
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
$title = "Sign Up";
require 'header.php';
if (isset($_SESSION['admin'])) {
        header('Location: http://localhost/Cab_Project/admin/admin_dashboard.php');
} elseif (isset($_SESSION['user'])) {
        header('Location: http://localhost/Cab_Project/user_dashboard.php');
}
if (isset($_POST['submit'])) {
    $username = (isset($_POST['username'])) ? $_POST['username'] : "";
    $name = (isset($_POST['name'])) ? $_POST['name'] : "";
    $mobile = (isset($_POST['mobile'])) ? $_POST['mobile'] : "";
    $arr = str_split($mobile);
    if (sizeof($arr) < 10 || sizeof($arr) >10) {
        echo "<script>alert('Mobile Number must contain 10 digits');</script>";
    } else {
        $password = (isset($_POST['password'])) ? $_POST['password'] : "";
        $pass = md5($password);
        $date = Date("Y-m-d h:i:s");
        $status = "0";
        $isAdmin = "0";
        $user = new User();
        $db = new DBconnection();
        $user->signup($username, $name, $mobile,  $pass, $date, $status, $isAdmin, $db->conn);
    }
}
?>
<div class="aa-login-form">
    <p>Welcome to <i style="font-weight:600;">CedCab</i></p>
    <form method="POST">
        <img src="image/images.jpeg" alt="User"><br><br>
        <label for="username">Username: </label><input type="text" 
                name="username" class="uname" required><br><br>
        <label for="name">Name: </label><input type="text" 
                name="name" class="name" required><br><br>
        <label for="mobile">Mobile No.: </label><input type="text" 
                name="mobile" class="numbers" required><br><br>
        <label for="password">Password: </label><input type="password" 
                name="password" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
<?php
require "footer.php";
?>