<?php
include 'config.php';

// Check if task_id parameter is set in the URL
if (isset($_GET['task_id'])) { // Change 'showid' to 'task_id'
    $taskId = $_GET['task_id']; // Change 'showid' to 'task_id'

    // Construct SQL query to delete task from database
    $sql = "DELETE FROM todo_items WHERE id='$taskId'";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        // Task deleted successfully
        echo "Task deleted successfully";
    } else {
        // Error deleting task
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} else {
    // If task_id parameter is not set, return an error
    echo "Task ID parameter not provided";
}

$con->close();
?>
