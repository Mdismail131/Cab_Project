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
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $arr = str_split($mobile);
    if (sizeof($arr) < 10 || sizeof($arr) >10) {
        echo "<script>alert('Mobile Number must contain 10 digits');</script>";
    } else {
        $sql = $user->update_info($username, $name, $mobile, $db->conn);
    }
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
                        Name:
                    </td>
                    <td>
                        <input type="text" name="name" size="15" value="<?php echo $row_user['name']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Mobile No.:
                    </td>
                    <td>
                        <input type="text" name="mobile"  size="15" class="numbers" placeholder="Contain 10 Digits" value="<?php echo $row_user['mobile']; ?>">
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