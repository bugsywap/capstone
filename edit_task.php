<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if task_id, task_text, and datetime parameters are set
    if (isset($_POST['task_id']) && isset($_POST['task_text']) && isset($_POST['datetime'])) {
        // Sanitize the input to prevent SQL injection
        $taskId = mysqli_real_escape_string($con, $_POST['task_id']);
        $taskText = mysqli_real_escape_string($con, $_POST['task_text']);
        $datetime = mysqli_real_escape_string($con, $_POST['datetime']);

        // Convert datetime to your timezone (Asia/Manila)
        date_default_timezone_set('Asia/Manila');
        $datetime = date('Y-m-d H:i:s', strtotime($datetime));

        // Update the task and datetime in the database
        $sql = "UPDATE todo_items SET task='$taskText', datetime='$datetime' WHERE id=$taskId";

        if (mysqli_query($con, $sql)) {
            // Task and datetime updated successfully
            echo "Task and datetime updated successfully";
        } else {
            // Error updating task and datetime
            echo "Error updating task and datetime: " . mysqli_error($con);
        }
    } else {
        // Missing parameters
        echo "Task ID, task content, and datetime must be provided";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}

mysqli_close($con);
?>
