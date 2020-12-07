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
class User
{
    
    /* Function for user and admin Login */
    function login($username, $password, $conn)
    {
        $pass = md5($password);
        $sql = "select * from `tbl_user` where `user_name` = '$username' and `password` = '$pass'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        if ($result->num_rows > 0 ) {
            if ($row['is_block'] == 0) {
                $rtrn = "You have to wait for the admin approval as you are not authorised yet.";
            }
            if ($row['isAdmin'] == '1') {
                if (!isset($_SESSION['admin'])) {
                    $_SESSION['admin'] = $row['user_name'];
                    header('Location: http://localhost/Cab_Project/admin/admin_dashboard.php');
                }
            }
            if ($row['is_block'] != 0 && $row['isAdmin'] == '0') {
                $_SESSION['user'] = $row['user_name'];
                $_SESSION['user_id'] = $row['user_id'] ;
                setcookie("member_login", $row['user_name'], time() + 3600);
                if (isset($_SESSION['data'])) {
                    include "Ride.php";
                    include "DBconnection.php";
                    $ride = new Ride();
                    $db =  new DBconnection();
                    $curr_loc = $_SESSION['data']['from'];
                    $destination = $_SESSION['data']['to'];
                    $cab_type = $_SESSION['data']['cab_type'];
                    if ($cab_type == "CedMicro") {
                        $luggage = 0;
                    } else {
                        $luggage = 0;
                        if ($luggage == 0) {
                            $luggage = 0;
                        } else {
                            $luggage = $_SESSION['data']['luggage'];
                        }
                    }
                    $distance = $_SESSION['distance'];
                    $date = Date("Y-m-d");
                    $cust_id = $_SESSION['user_id'];
                    $fare = $_SESSION['fare'];
                    $ride->book_ride($curr_loc, $destination, $cab_type, $luggage, $distance, $date, $cust_id, $fare, $db->conn);
                    ?><script>alert("Successfully booked but you have to wait for Admin's approval")</script><?php
                    header('refresh:0; url=pending_rides.php');
                } else {
                    header('Location: http://localhost/Cab_Project/user_dashboard.php');
                }
            }
        } else {
            $rtrn = "You don't have an account on CedCab Please <a href='signup.php'>signup</a>";
        }
        return $rtrn;
    }

    /* Function for user SignUp */
    function signup($username, $name, $mobile,  $pass, $date, $status, $isAdmin, $conn)
    {
        $sql = "select * from `tbl_user` where `user_name` = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0 ) {
            ?>
            <script>alert("Username Already Exist");</script>
            <?php
        } else {
            $sql1 = "INSERT INTO `tbl_user`(`user_name`, `name`, `date_of_signup`, `mobile`, `is_block`, `password`, `isAdmin`) VALUES ('$username', '$name', '$date', '$mobile', '$status' , '$pass', '$isAdmin' )";
            $result1 = $conn->query($sql1);
            if (isset($result1)) {
            ?><script>alert("Successfully Signup please wait for Admin authentication");</script><?php
            } else {
            ?><script>alert("Please Provide Valid Inputs");</script><?php
            }
        }
    }

    /* Function for selecting a distinct Users */
    function distinct_user($username, $conn)
    {
        $sql = "select * from `tbl_user` where `user_name` = '$username'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /* Function returns pending users */
    function user_pending($conn)
    {
        $a = array();
        $sql = "select * from `tbl_user` where `is_block` = '0'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }

    /* Function returns authenticated users */
    function authen_user($conn)
    {
        $a = array();
        $sql = "select * from `tbl_user` where `is_block` = '1' and `isAdmin` != '1'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }

    /* Function returns all users */
    function all_users($conn)
    {
        $a = array();
        $sql = "select * from `tbl_user` where `isAdmin` != '1'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }

    /* Function for a allow user*/
    function allow_user($user_id, $conn)
    {
        $sql = "UPDATE `tbl_user` SET `is_block`= '1' WHERE `user_id` = '$user_id'";
        $result = $conn->query($sql);
    }

    /* Function for a block user*/
    function block_user($user_id, $conn)
    {
        $sql = "UPDATE `tbl_user` SET `is_block`= '0' WHERE `user_id` = '$user_id'";
        $result = $conn->query($sql);
    }

    /* Function for a delete user*/
    // function delete($user_id, $to_do, $conn)
    // {
    //     if ($to_do == "") {
    //         $sql = "delete * form `tbl_ride` where `ride_id` = '$user_id'";
    //         $result = $conn->query($sql);
    //     } else {
    //         $sql = "delete from `tbl_user` where `user_id` = '$user_id'";
    //         $sql1 = "delete form `tbl_ride` where `customer_user_id` = '$user_id'";
    //         $result = $conn->query($sql);
    //         $result1 = $conn->query($sql1);
    //     }
    // }

    /* Function for a update user-info*/
    function update_info($username, $name, $mobile, $conn) 
    {
        $sql = "UPDATE `tbl_user` SET `name`= '$name', `mobile`='$mobile' WHERE `user_name` = '$username'";
        $result = $conn->query($sql);
        echo "<script>alert('Your details are successfully updated')</script>";
        header('refresh:0, url= http://localhost/Cab_Project/user_dashboard.php');
        return $rtrn;
    }

    /* Function for a user-password*/
    function update_pass($username, $password, $curr_pass, $new_pass, $conn) 
    {
        if ($password == md5($curr_pass)) {
            $pass = md5($new_pass);
            if ($password == $pass) {
                echo "<script>alert('Current password and new password must be different')</script>";
            } else {
                $sql = "UPDATE `tbl_user` SET `password` = '$pass' WHERE `user_name` = '$username'";
                $result = $conn->query($sql);
                echo "<script>alert('Your details are successfully updated')</script>";
                header('refresh:0, url=user_dashboard.php');
            }
        } else {
            echo "<script>alert('Current password Error')</script>";
        }
    }

    /* Function for a pick a particular name*/
    function pick_name($conn) 
    {
        $a = array();
        $sql = "select * from `tbl_user`";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }

    /* Function for a Join a table*/
    public function join_table($conn)
    {
        $row_user = array();
        $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($row_user, $row);
            }
        }
        return $row_user;
    }

    /* Function for filter by date*/
    public function filter_by_date($date_first, $date_Second, $to_do, $conn) 
    {
        if ($to_do == "user_signup") {
            $a = array();
            $sql = "select * from `tbl_user` where `isAdmin` = '0' and date(`date_of_signup`) BETWEEN date('$date_first') and date('$date_Second')";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "user") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and date(`ride_date`) BETWEEN date('$date_first') and date('$date_Second')";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "ride_comp") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `status` = '2' and date(`ride_date`) BETWEEN date('$date_first') and date('$date_Second')";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "ride_cancel") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `status` = '0' and date(`ride_date`) BETWEEN date('$date_first') and date('$date_Second')";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "ride_pend") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `status` = '1' and date(`ride_date`) BETWEEN date('$date_first') and date('$date_Second')";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } else {
            $a = array();
            $user = new User();
            $row = $user->join_table($conn);
            foreach ($row as $key => $values) {
                if ($values['ride_date'] >= $date_first && $values['ride_date'] <= $date_Second) {
                    array_push($a, $row[$key]);
                }
            }
        }
        return $a;
    }

    /* Function for filter by name*/
    public function filter_by_name($name, $to_do, $conn) 
    {
        $a = array();
        $user = new User();
        if ($to_do == "user_signup") {
            $sql = "select * from `tbl_user` where `isAdmin` = '0' and `user_name` = '$name'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } else {
            $row = $user->join_table($conn);
            foreach ($row as $key => $values) {
                if ($values['user_name'] == $name) {
                    array_push($a, $row[$key]);
                }
            }
            return $a;
        }
    }
    /* Function for filter by fare*/
    public function filter_by_fare($fare, $to_do, $conn) 
    {
        if ($to_do == 'user') {
            $a = array();
            $user = new User();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `total_fare` = '$fare'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "ride_pend") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `status` = '1' and `total_fare` = '$fare'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } elseif ($to_do == "ride_cancel") {
            $a = array();
            $user_id = $_SESSION['user_id'];
            $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$user_id' and `status` = '0' and `total_fare` = '$fare'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
            }
        } else {
            $a = array();
            $user = new User();
            $row = $user->join_table($conn);
            foreach ($row as $key => $values) {
                if ($values['total_fare'] == $fare) {
                    array_push($a, $row[$key]);
                }
            }
        }
        return $a;
    }

    /* Function for sort data in ascending order*/
    public function sort_data($sort_by, $to_do, $conn)  
    {
        $a = array();
        if ($to_do == "signup") {
            if ($sort_by == 'user_name') {
                $sql = "select * from `tbl_user` where `isAdmin` != '1' order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` where `isAdmin` != '1' order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "") {
            if ($sort_by == 'user_name' || $sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "user") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_comp") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '2' order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '2' order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_pend") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '1' order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '1' order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_cancel") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '0' order by `$sort_by`";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '0' order by cast(`$sort_by` as unsigned)";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "invoice") {
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `isAdmin` = '0' order by `$sort_by`";
            } 
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "pending") {
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `is_block` = '0' order by `$sort_by`";
            } else {
                $sql = "Select * from `tbl_user` where `is_block` = '0' order by cast(`$sort_by` as unsigned)"; 
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "user_appr") {
            // $id = $_SESSION['user_id'];
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `is_block` = '1' and `isAdmin` = '0' order by `$sort_by`";
            } else {
                $sql = "Select * from `tbl_user` where `is_block` = '1' and `isAdmin` = '0' order by cast(`$sort_by` as unsigned)"; 
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        }
    }

    /* Function for sort data in descending order*/
    public function sort_data_desc($sort_by, $to_do, $conn)  
    {
        $a = array();
        if ($to_do == "signup") {
            if ($sort_by == 'user_name') {
                $sql = "select * from `tbl_user` where `isAdmin` != '1' order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` where `isAdmin` != '1' order by cast(`$sort_by` as unsigned) desc";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "") {
            if ($sort_by == 'user_name' || $sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id order by cast(`$sort_by` as unsigned) desc";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "user") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' order by cast(`$sort_by` as unsigned) desc";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_comp") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '2' order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '2' order by cast(`$sort_by` as unsigned) desc";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_cancel") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '0' order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '0' order by cast(`$sort_by` as unsigned) desc";
            }$result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "ride_pend") {
            $id = $_SESSION['user_id'];
            if ($sort_by == 'cab_type') {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '1' order by `$sort_by` desc";
            } else {
                $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `user_id` = '$id' and `status` = '1' order by cast(`$sort_by` as unsigned) desc";
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "invoice") {
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `isAdmin` = '0' order by `$sort_by` desc";
            } 
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "pending") {
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `is_block` = '0' order by `$sort_by` desc";
            } else {
                $sql = "Select * from `tbl_user` where `is_block` = '0' order by cast(`$sort_by` as unsigned) desc"; 
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } elseif ($to_do == "user_appr") {
            if ($sort_by == 'user_name') {
                $sql = "Select * from `tbl_user` where `is_block` = '1' and `isAdmin` = '0' order by `$sort_by` desc";
            } else {
                $sql = "Select * from `tbl_user` where `is_block` = '1' and `isAdmin` = '0' order by cast(`$sort_by` as unsigned) desc"; 
            }
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        }
    }

    /* Function for user details*/
    function user_details($conn)
    {
        $a = array();
        $sql = "select * from `tbl_user` where `isAdmin` != '1'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }

    /* Function for User invoice*/
    function invoice($ride_id, $conn)
    {
        $a = array();
        $sql = "select * from `tbl_user` inner join `tbl_ride` on `tbl_user`.user_id = `tbl_ride`.customer_user_id where `ride_id` = '$ride_id'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        }
    }
}
?>
