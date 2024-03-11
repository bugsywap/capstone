<?php
include 'config.php';

// Set the timezone to Philippine Standard Time
date_default_timezone_set('Asia/Manila');

if (isset($_GET['showid'])) {
    $patientId = $_GET['showid'];

    // Retrieve tasks from database
    $sql = "SELECT * FROM todo_items WHERE patient_id='$patientId'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Get the current server time in Philippine Standard Time
        $currentDateTime = date('F j, Y, g:i a');

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<li class="' . strtolower(str_replace(' ', '-', $row['phase'])) . '" data-task-id="' . $row['id'] . '">' . $row['phase'] . ': ' . $row['task'] . ' (' . formatDate($row['datetime']) . ')
            <button class="edit" onclick="editTask(this)">Edit</button><span>&times;</span></li>';
        }
    }
}

$con->close();

// Function to format date
function formatDate($date)
{
    return date('F j, Y, g:i a', strtotime($date));
}
