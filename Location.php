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

class Location
{
    public function show($conn) 
    {
        if (isset($_SESSION['user'])) {
            $a = array();
            $sql = "select * from `tbl_location` where `is_available` = '1'";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        } else {
            $a = array();
            $sql = "select * from `tbl_location` order by cast(distance as unsigned)";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($a, $row);
                }
                return $a;
            }
        }
    }
    /*Block Location */
    public function block_loc($id, $conn) 
    {
        $sql = "UPDATE `tbl_location` SET `is_available` = '0' WHERE `id` = '$id'";
        $result = $conn->query($sql);
    }
    /*unblock Location */
    public function unblock_loc($id, $conn) 
    {
        $sql = "UPDATE `tbl_location` SET `is_available` = '1' WHERE `id` = '$id'";
        $result = $conn->query($sql);
    }
    /*Add Location */
    public function add_loc($location, $distance, $avail, $conn) 
    {
        $sql = "select * from `tbl_location` where 'name' = '$location'";
        $result1 = $conn->query($sql);
        if ($result->num_rows>0) {
            echo "<script>alert('Location Already exist')</script>";
            header('Refresh: 0, url=admin/loc_control.php');
        } else {
            $sql1 = "INSERT INTO `tbl_location`(`name`, `distance`, `is_available`) VALUES ('$location', '$distance', '$avail')";
            $result = $conn->query($sql1);
            echo "<script>alert('Location Successfully Added')</script>";
            header('Refresh: 0, url=admin/loc_control.php');
        }
    } 
    /*Update Location */
    public function update($id, $location, $distance, $conn) 
    {
        $sql = "UPDATE `tbl_location` SET `name` = '$location' , `distance` = '$distance' WHERE `id` = '$id'";
        $result = $conn->query($sql);
    }
    /*Delete Location */
    public function delete($id, $conn) 
    {
        $sql = "DELETE FROM `tbl_location` WHERE `id` = '$id'";
        $result = $conn->query($sql);
    }

    public function filter_by_name($name, $conn) 
    {
        $a = array();
        $sql = "select * from `tbl_location` where `name` = '$name'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        } 
    }

    public function filter_by_distance($distance, $conn)
    {
        $a = array();
        $sql = "select * from `tbl_location` where `distance` = '$distance'";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        } 
    }

    public function sort_by($sort_by, $conn)
    {
        $a = array();
        $sql = "select * from `tbl_location` order by `$sort_by`";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        } 
    }
    public function sort_by_desc($sort_by, $conn)
    {
        $a = array();
        $sql = "select * from `tbl_location` order by `$sort_by` desc";
        $result = $conn->query($sql);
        if ($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a, $row);
            }
            return $a;
        } 
    }
}