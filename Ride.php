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

class Ride
{
    public function all_ride($id, $conn) 
    {
        if (isset($_SESSION['user'])) {
            $a = array();
            $sql = "select * from `tbl_ride` where `customer_user_id` = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            } 
        }
    }
    public function pending_ride($id, $conn) 
    {
        if (isset($_SESSION['admin']) && $id == "") {
            $a = array();
            $sql = "select * from `tbl_ride` inner join `tbl_user` on `tbl_ride`.customer_user_id = `tbl_user`.user_id where `status` = '1' and `is_block` = '1'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            } 
        } else {
            if (isset($_SESSION['user'])) {
                $a = array();
                if (isset($id) && $id != "") { 
                    $sql = "select * from `tbl_ride` where `customer_user_id` = '$id' and `status` = '1'";
                } else {
                    $sql = "select * from `tbl_ride` where `status` = '1'";
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
    }
    public function completed_rides($id, $conn) 
    {
        if (isset($_SESSION['admin']) && $id == "") {
            $a = array();
            $sql = "select * from `tbl_ride` inner join `tbl_user` on `tbl_ride`.customer_user_id = `tbl_user`.user_id where `status` = '2'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            } 
        } else {
            $a = array();
            if (isset($id) && $id == "") {
                $sql = "select * from `tbl_ride` where `status` = '2'";
            } else {
                $sql = "select * from `tbl_ride` where `customer_user_id` = '$id' and `status` = '2'";
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
    public function cancelled_rides($id, $conn) 
    {
        if (isset($_SESSION['admin']) && $id == "") {
            $a = array();
            $sql = "select * from `tbl_ride` inner join `tbl_user` on `tbl_ride`.customer_user_id = `tbl_user`.user_id where `status` = '2'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            } 
        } else {
            $a = array();
            if (isset($id) && $id == "") {
                $sql = "select * from `tbl_ride` where `status` = '0'";
            } else {
                $sql = "select * from `tbl_ride` where `customer_user_id` = '$id' and `status` = '0'";
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
    public function cancel_ride($id, $conn) 
    {
        if (isset($id) && $id != "") {
            $sql = "UPDATE `tbl_ride` SET `status` = '0' WHERE `ride_id` = '$id' and `status` = '1'";
            $result = $conn->query($sql);
        } else {
            $a = array();
            $sql = "select * from `tbl_ride` where `status` = 0";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        }
    }

    public function approved($id, $conn) 
    {
        $sql = "UPDATE `tbl_ride` SET `status` = '2' WHERE `ride_id` = '$id' and `status` = '1'";
        $result = $conn->query($sql);
        return $sql;
    }

    public function delete($id, $conn) 
    {
        $sql = "DELETE FROM `tbl_ride` WHERE `ride_id` = '$id'";
        $result = $conn->query($sql);
    }

    public function book_ride($curr_loc, $destination, $cab_type, $luggage, $distance, $date, $cust_id, $fare, $conn)
    {
        if (isset($_SESSION['data'])) {
            $sql1 = "INSERT INTO `tbl_ride`(`ride_date`, `from_loc`, `to_loc`, `total_distance`, `cab_type`, `luggage`, `total_fare`, `status`, `customer_user_id`) VALUES ('$date', '$curr_loc', '$destination', '$distance', '$cab_type', '$luggage', '$fare', '1' , '$cust_id')";
            $result1 = $conn->query($sql1);
            unset($_SESSION['fare']);
            unset($_SESSION['distance']);
            unset($_SESSION['data']);
        } else {
            $sql1 = "INSERT INTO `tbl_ride`(`ride_date`, `from_loc`, `to_loc`, `total_distance`, `cab_type`, `luggage`, `total_fare`, `status`, `customer_user_id`) VALUES ('$date', '$curr_loc', '$destination', '$distance', '$cab_type', '$luggage', '$fare', '1' , '$cust_id')";
            $result1 = $conn->query($sql1);
            unset($_SESSION['fare']);
            unset($_SESSION['distance']);
            ?><script>alert("Your have to wait for the Admin approval");</script><?php
        }
    }
    public function fetchEarningData($conn) 
    {
        $sql = "SELECT sum(`total_fare`) AS `total`, `ride_date` FROM `tbl_ride` GROUP BY `ride_date`";
        $result1 = $conn->query($sql);
        if ($result1->num_rows>0) {
            return $result1;
        } else {
            return '0';
        }

    }
}
?>