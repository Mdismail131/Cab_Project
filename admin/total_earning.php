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
require "sidebar.php";
require "DBconnection.php";
require "../User.php";
require "../Ride.php";
$title = "All Rides";
if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/Cab_Project/login.php');
}
$earning = new Ride();
$db = new DBconnection();
$rows = $earning->fetchEarningData($db->conn);
$Dates = [];
$totalEarning = [];
if ($rows != "") {
    foreach ($rows as $row) {
        $Dates[] = $row['ride_date'];
        $totalEarning[] = $row['total'];
    }
}
?>
<div id="chart">
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var dates = <?php echo json_encode($Dates); ?>;
    var earnings = <?php echo json_encode($totalEarning); ?>;
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'My dataset',
                backgroundColor: 'rgb(179,163,140)',
                borderColor: 'rgb(255, 99, 132)',
                data: earnings
            }]
        },
        options: {}
    });
</script>