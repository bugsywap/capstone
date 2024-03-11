<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dskafagway";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die(mysqli_error($con));
}
// Function to execute queries
function performQuery($sql)
{
    global $con;
    return $con->query($sql);
}

// Function to fetch data
function fetchData($sql)
{
    global $con;
    $result = $con->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
