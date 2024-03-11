<?php
include 'config.php';

// Retrieve task data from POST request
$data = json_decode(file_get_contents('php://input'), true);
if (isset($_GET['showid']) && isset($data['phase']) && isset($data['task']) && isset($data['datetime'])) {
    $patientId = $_GET['showid'];
    $phase = $data['phase'];
    $task = $data['task'];
    $datetime = $data['datetime'];

    // Adjust the datetime to match the server timezone (Asia/Manila)
    date_default_timezone_set('Asia/Manila');
    $datetime = date('Y-m-d H:i:s', strtotime($datetime));

    // Insert task data into the database
    $sql = "INSERT INTO todo_items (patient_id, phase, task, datetime) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isss", $patientId, $phase, $task, $datetime);
    if ($stmt->execute()) {
        // Task added successfully
        echo json_encode(['success' => true]);
    } else {
        // Error adding task
        echo json_encode(['success' => false, 'message' => 'Error adding task']);
    }
} else {
    // Invalid request
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$con->close();
?>
