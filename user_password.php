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
$title = "User Dashboard";
require "header.php";
if (!isset($_SESSION['user'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
$user = new User();
$db = new DBconnection();
$row_user = $user->distinct_user($_SESSION['user'], $db->conn);
if (isset($_POST['update'])) {
    $username = $row_user['user_name'];
    $password = $row_user['password'];
    $curr_pass = $_POST['curr_password'];
    $new_pass = $_POST['new_password'];
    $sql = $user->update_pass($username, $password, $curr_pass, $new_pass, $db->conn);
}   
?>
<div id="past">
    <div id="dash1">
        <form method="post">
            <table id="dash_table">
                <tr>
                    <td colspan="2">
                        <img id="image" src="image/images.jpeg" alt="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Current Password:
                    </td>
                    <td>
                        <input type="password" name="curr_password" size="15">
                    </td>
                </tr>
                <tr>
                    <td>
                        New Password:
                    </td>
                    <td>
                        <input type="password" name="new_password" size="15">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" onClick="return confirm('Are you confirm?');" name="update" value="Update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
require "footer.php";
?>