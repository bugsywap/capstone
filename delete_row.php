<?php
include 'config.php';
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM `dChartTable` WHERE id = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // Alert the user that the dental chart has been reset
        echo '<script>alert("The dental chart has been reset.");</script>';
        // Go back one page
        echo '<script>window.history.back();</script>';
    }
}
