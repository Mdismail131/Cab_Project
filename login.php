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
$title = "Log In";
require "header.php";
if (!isset($_SESSION['start'])) {
    $_SESSION['start'] = time();
} elseif (time() - $_SESSION['start'] > 180) {
    unset($_SESSION['data']);
}
if (isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/admin/admin_dashboard.php');
} elseif (isset($_SESSION['user'])) {
    header('Location: http://localhost/Cab_Project/user_dashboard.php');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new User();
    $db = new DBconnection();

    $sql = $user->login($username, $password, $db->conn);
}
?>

<div class="aa-login-form">
    <p>Welcome to <i style="font-weight:600;">CedCab</i></p>
    <form method="POST">
        <img src="image/images.jpeg" alt="user"><br><br>
        <label for="username">Username: </label>
        <input type="text" name="username" value="<?php if (isset($_COOKIE['member_login'])) { echo $_COOKIE['member_login']; } ?>" required><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php if (isset($sql)) { ?>
    <div id="result">
        <?php echo $sql?>
    </div>
    <?php } ?>
</div>
<?php
require "footer.php";
?>