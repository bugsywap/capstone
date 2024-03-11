<?php
include 'config.php';
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "DELETE From `patientApt` where id = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location:apt.php');
    } else {
        die(mysqli_error($con));
    }
}
